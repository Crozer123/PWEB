<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Rental;
use App\Models\RentalDetail;
use App\Models\Item;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRentalRequest;

class CustomerOrderController extends Controller
{
    // ==========================================================
    // BAGIAN 1: FITUR LAMA (Sewa Langsung & Pembayaran)
    // ==========================================================

    // Halaman Form Sewa Langsung (Single Item)
    public function createSingle(Item $item)
    {
        return view('customer.order.create-single', compact('item'));
    }

    // Proses Simpan Sewa (Dari Sewa Langsung)
    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();

        // 1. Ambil item dari hidden input
        $itemsToProcess = [];
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $val) {
                $itemsToProcess[$val['item_id']] = ['quantity' => $val['quantity']];
            }
        } else {
            return back()->with('error', 'Tidak ada barang yang dipilih.');
        }

        // 2. Validasi Stok
        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            if (!$item || $item->stock < $data['quantity']) {
                return back()->with('error', "Stok {$item->name} tidak mencukupi.");
            }
        }

        // 3. Buat Header Rental
        $rental = Rental::create([
            'user_id'      => Auth::id(),
            'rental_date'  => $validated['rental_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
            'total_price'  => 0,
        ]);

        $grandTotal = 0;

        // 4. Simpan Detail & Kurangi Stok
        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            $subtotal = $item->rental_price * $data['quantity'];
            $grandTotal += $subtotal;

            RentalDetail::create([
                'rental_id'      => $rental->id,
                'item_id'        => $item->id,
                'quantity'       => $data['quantity'],
                'subtotal_price' => $subtotal,
            ]);

            $item->decrement('stock', $data['quantity']);
        }

        // Update Total
        $rental->update(['total_price' => $grandTotal]);

        // Redirect ke halaman pembayaran
        return redirect()->route('customer.order.payment', $rental->id);
    }

    // Halaman Pembayaran (Midtrans) - INI YANG HILANG SEBELUMNYA
    public function showPayment(Rental $rental)
    {
        // Pastikan user yang akses adalah pemilik rental
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pembayaran ini.');
        }

        // Jika token belum ada, generate snap token baru
        if (empty($rental->snap_token)) {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $rental->id . '-' . time(),
                    'gross_amount' => (int) $rental->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $rental->snap_token = $snapToken;
                $rental->save();
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        }

        return view('customer.order.payment', compact('rental'));
    }

    // Halaman Sukses
    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) abort(403);
        return view('customer.order.success', compact('rental'));
    }


    // ==========================================================
    // BAGIAN 2: FITUR KERANJANG (CART SYSTEM) - BARU
    // ==========================================================

    // 1. Masukkan ke Keranjang
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

    // 2. Lihat Halaman Keranjang
    public function cart()
    {
        $user = Auth::user();
        $cart = Cart::with(['items.item'])->where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->items : collect([]);

        return view('customer.order.cart', compact('cartItems'));
    }

    // 3. Hapus Item dari Keranjang
    public function removeCartItem($id)
    {
        $cartItem = CartItem::find($id);
        
        if ($cartItem && $cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
            return back()->with('success', 'Barang dihapus dari keranjang.');
        }

        return back()->with('error', 'Gagal menghapus barang.');
    }

    // 4. Checkout dari Keranjang (Sewa Sekarang)
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

        $grandTotal = 0;
        foreach ($cart->items as $ci) {
            if ($ci->item->stock < $ci->quantity) {
                return back()->with('error', "Stok untuk {$ci->item->name} tidak mencukupi.");
            }
            $grandTotal += $ci->item->rental_price * $ci->quantity;
        }

        // Buat Transaksi Rental
        $rental = Rental::create([
            'user_id' => $user->id,
            'rental_date' => $request->rental_date,
            'return_date' => $request->return_date,
            'status' => 'pending',
            'total_price' => $grandTotal
        ]);

        // Pindahkan Item Keranjang ke Detail Rental
        foreach ($cart->items as $ci) {
            RentalDetail::create([
                'rental_id' => $rental->id,
                'item_id' => $ci->item_id,
                'quantity' => $ci->quantity,
                'subtotal_price' => $ci->item->rental_price * $ci->quantity
            ]);

            // Kurangi Stok Barang
            $ci->item->decrement('stock', $ci->quantity);
        }

        // Kosongkan Keranjang
        $cart->items()->delete();

        // Redirect ke Pembayaran
        return redirect()->route('customer.order.payment', $rental->id);
    }
}