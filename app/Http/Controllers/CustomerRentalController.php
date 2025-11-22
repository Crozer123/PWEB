<?php
namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\RentalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerRentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::where('user_id', Auth::id())
                        ->where('status', '!=', 'pending') 
                        ->with('items') // Pastikan relasi items ada
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('customer.rentals.index', compact('rentals')); 
    }
    
    public function show(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        
        return view('customer.rentals.show', compact('rental'));
    }
    public function cart()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with('item')->get();

        return view('customer.cart.index', compact('cart', 'items'));
    }

     public function addToCart(Item $item)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $existing = CartItem::where('cart_id', $cart->id)
                            ->where('item_id', $item->id)
                            ->first();

        if ($existing) {
            $existing->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'item_id' => $item->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Ditambahkan ke keranjang!');
    }

    public function updateCart(Request $request, CartItem $cartItem)
    {
        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Jumlah berhasil diperbarui.');
    }

    public function removeItem(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Item dihapus.');
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() < 1) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'status'  => 'pending',
        ]);

        foreach ($cart->items as $itemRow) {
            RentalDetail::create([
                'rental_id' => $rental->id,
                'item_id'   => $itemRow->item_id,
                'quantity'  => $itemRow->quantity,
            ]);

            $itemRow->item->decrement('stock', $itemRow->quantity);
        }

        // Kosongkan keranjang
        $cart->items()->delete();

        return redirect()->route('customer.order.success', $rental->id);
    }

    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) abort(403);

        return view('customer.order.success', compact('rental'));
}

}