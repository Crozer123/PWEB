<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentalDetail;
use App\Models\Item;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRentalRequest;
use Carbon\Carbon; 

class CustomerOrderController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['details.item']) 
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10); 

        return view('customer.order.index', compact('rentals'));
    }

    public function createSingle(Item $item)
    {
        return view('customer.order.create-single', compact('item'));
    }

    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();
        $rentalDate = Carbon::parse($validated['rental_date']);
        $returnDate = Carbon::parse($validated['return_date']);
        $days = $rentalDate->diffInDays($returnDate) + 1;

        $itemsToProcess = [];
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $val) {
                $itemsToProcess[$val['item_id']] = ['quantity' => $val['quantity']];
            }
        } else {
            return back()->with('error', 'Tidak ada barang yang dipilih.');
        }

        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            if (!$item || $item->stock < $data['quantity']) {
                return back()->with('error', "Stok {$item->name} tidak mencukupi.");
            }
        }

        $rental = Rental::create([
            'user_id'      => Auth::id(),
            'rental_date'  => $validated['rental_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
            'total_price'  => 0,
        ]);

        $grandTotal = 0;

        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            $subtotal = $item->rental_price * $data['quantity'] * $days;
            $grandTotal += $subtotal;

            RentalDetail::create([
                'rental_id'      => $rental->id,
                'item_id'        => $item->id,
                'quantity'       => $data['quantity'],
                'subtotal_price' => $subtotal,
            ]);

            $item->decrement('stock', $data['quantity']);
        }
        $rental->update(['total_price' => $grandTotal]);
        return redirect()->route('customer.order.payment', $rental->id);
    }

    public function showPayment(Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pembayaran ini.');
        }

        if ($rental->status !== 'pending' && $rental->payment_status === 'paid') {
            return redirect()->route('customer.dashboard')
                ->with('info', 'Transaksi ini sudah dibayar.');
        }

        // Logika Midtrans (Config & Snap Token) telah dihapus.
        // Langsung tampilkan view pembayaran.

        return view('customer.order.payment', compact('rental'));
    }

    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) abort(403);
        return view('customer.order.success', compact('rental'));
    }

    public function addToCart(Request $request, Item $item)
    {
        $user = Auth::user();

        if ($item->stock < 1) {
            return back()->with('error', 'Stok barang habis.');
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cartItem = $cart->items()->where('item_id', $item->id)->first();

        if ($cartItem) {
            if ($cartItem->quantity + 1 > $item->stock) {
                return back()->with('error', 'Stok tidak mencukupi untuk menambah jumlah.');
            }
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'item_id' => $item->id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('customer.cart')->with('success', 'Barang berhasil dimasukkan ke keranjang!');
    }

    public function cart()
    {
        $user = Auth::user();
        $cart = Cart::with(['items.item'])->where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items : collect([]);

        return view('customer.order.cart', compact('cartItems'));
    }

    public function removeCartItem($id)
    {
        $cartItem = CartItem::find($id);
        
        if ($cartItem && $cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
            return back()->with('success', 'Barang dihapus dari keranjang.');
        }

        return back()->with('error', 'Gagal menghapus barang.');
    }

    public function checkoutCart(Request $request)
    {
        $request->validate([
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:rental_date',
        ]);

        $user = Auth::user();
        $cart = Cart::with('items.item')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        $rentalDate = Carbon::parse($request->rental_date);
        $returnDate = Carbon::parse($request->return_date);
        $days = $rentalDate->diffInDays($returnDate) + 1;

        $grandTotal = 0;
        foreach ($cart->items as $ci) {
            if ($ci->item->stock < $ci->quantity) {
                return back()->with('error', "Stok untuk {$ci->item->name} tidak mencukupi.");
            }
            $grandTotal += $ci->item->rental_price * $ci->quantity * $days;
        }

        $rental = Rental::create([
            'user_id' => $user->id,
            'rental_date' => $request->rental_date,
            'return_date' => $request->return_date,
            'status' => 'pending',
            'total_price' => $grandTotal
        ]);

        foreach ($cart->items as $ci) {
            RentalDetail::create([
                'rental_id' => $rental->id,
                'item_id' => $ci->item_id,
                'quantity' => $ci->quantity,
                'subtotal_price' => $ci->item->rental_price * $ci->quantity * $days
            ]);

            $ci->item->decrement('stock', $ci->quantity);
        }

        $cart->items()->delete();

        return redirect()->route('customer.order.payment', $rental->id);
    }

    public function processCod(Request $request, Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($rental->status !== 'pending') {
            return back()->with('error', 'Status pesanan tidak valid untuk perubahan metode pembayaran.');
        }

        $rental->update([
            'payment_method' => 'cod', 
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Metode pembayaran COD berhasil dipilih. Silakan lakukan pembayaran tunai saat mengambil barang di toko.');
    }
}