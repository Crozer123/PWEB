<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentalDetail;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRentalRequest;

class CustomerOrderController extends Controller
{
    // =============== CART ==================

    public function addToCart(Item $item)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$item->id])) {
            $cart[$item->id]['quantity']++;
        } else {
            $cart[$item->id] = [
                'name' => $item->name,
                'price' => $item->rental_price,
                'image' => $item->image,
                'quantity' => 1,
                'stock' => $item->stock
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Barang ditambahkan ke keranjang!');
    }


    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('customer.order.cart', compact('cart'));
    }


    public function updateCart(Request $request, Item $item)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$item->id])) {
            $cart[$item->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Jumlah diperbarui!');
    }


    public function removeFromCart(Item $item)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$item->id])) {
            unset($cart[$item->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Barang dihapus dari keranjang!');
    }


    // =============== CHECKOUT ===============

    public function create()
    {
        $cart = session()->get('cart', []);

        if (!$cart || count($cart) === 0) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang masih kosong.');
        }

        return view('customer.order.checkout', compact('item'));
    }

    public function createSingle(Item $item)
    {
        return view('customer.order.create-single', compact('item'));
    }



    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();
        $cart = session()->get('cart', []);

        if (!$cart || count($cart) === 0) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $rental = Rental::create([
            'user_id'      => Auth::id(),
            'rental_date'  => $validated['rental_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
        ]);

        foreach ($cart as $itemId => $data) {

            $item = Item::find($itemId);

            if ($item->stock < $data['quantity']) {
                return back()->with('error', "Stok untuk {$item->name} tidak cukup.");
            }

            RentalDetail::create([
                'rental_id' => $rental->id,
                'item_id'   => $item->id,
                'quantity'  => $data['quantity'],
            ]);

            $item->decrement('stock', $data['quantity']);
        }

        session()->forget('cart');

           return view('customer.order.checkout', [
        'rental' => $rental,
        'success' => true,
        'cart' => []
]);
    }

    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.order.success', compact('rental'));
    }

    
}
