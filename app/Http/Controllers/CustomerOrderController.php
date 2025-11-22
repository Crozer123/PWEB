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
        
        // 1. Tentukan sumber data: Apakah dari Form Langsung (Single) atau Session (Cart)?
        $itemsToProcess = [];

        if ($request->has('items') && is_array($request->items)) {
            // KASUS A: Sewa Langsung (Klik "Sewa Sekarang")
            foreach ($request->items as $val) {
                $itemsToProcess[$val['item_id']] = [
                    'quantity' => $val['quantity']
                ];
            }
        } else {
            // KASUS B: Checkout dari Keranjang
            $cart = session()->get('cart', []);
            if (!$cart || count($cart) === 0) {
                return back()->with('error', 'Keranjang kosong.');
            }
            // Format ulang data session biar seragam
            foreach ($cart as $id => $details) {
                $itemsToProcess[$id] = [
                    'quantity' => $details['quantity']
                ];
            }
        }

        // 2. Validasi Stok Dulu (Sebelum Simpan Apapun)
        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            if (!$item || $item->stock < $data['quantity']) {
                return back()->with('error', "Stok untuk {$item->name} tidak cukup.");
            }
        }

        // 3. Simpan Data Rental (Header)
        // Kita set total_price 0 dulu, nanti diupdate setelah hitung detail
        $rental = Rental::create([
            'user_id'      => Auth::id(),
            'rental_date'  => $validated['rental_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
            'total_price'  => 0 
        ]);

        $grandTotal = 0;

        // 4. Simpan Detail Barang & Hitung Harga
        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            
            // Hitung subtotal per item
            $subtotal = $item->rental_price * $data['quantity'];
            $grandTotal += $subtotal;

            RentalDetail::create([
                'rental_id'      => $rental->id,
                'item_id'        => $item->id,
                'quantity'       => $data['quantity'],
                'subtotal_price' => $subtotal, // <--- INI YANG TADINYA KURANG
            ]);

            // Kurangi stok barang
            $item->decrement('stock', $data['quantity']);
        }

        // 5. Update Total Harga di Tabel Rental
        $rental->update(['total_price' => $grandTotal]);

        // 6. Hapus Keranjang (Hanya jika checkout berasal dari keranjang)
        if (!$request->has('items')) {
            session()->forget('cart');
        }

        // Redirect ke halaman history rental dengan pesan sukses
        return redirect()
            ->route('customer.rentals.history')
            ->with('success', 'Penyewaan berhasil dibuat! Menunggu konfirmasi admin.');
            }
    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.order.success', compact('rental'));
    }

    
}
