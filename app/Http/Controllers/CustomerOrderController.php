<?php

namespace App\Http\Controllers;
use Midtrans\Config;
use Midtrans\Snap;
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

        // --- 1. AMBIL ITEM DARI CART ATAU FORM ---
        $itemsToProcess = [];
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $val) {
                $itemsToProcess[$val['item_id']] = ['quantity' => $val['quantity']];
            }
        } else {
            $cart = session()->get('cart', []);
            if (!$cart || count($cart) === 0) return back()->with('error', 'Keranjang kosong.');
            foreach ($cart as $id => $details) {
                $itemsToProcess[$id] = ['quantity' => $details['quantity']];
            }
        }

        // --- 2. VALIDASI STOK ---
        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            if (!$item || $item->stock < $data['quantity']) {
                return back()->with('error', "Stok {$item->name} kurang.");
            }
        }

        // --- 3. SIMPAN DATA RENTAL (HEADER) ---
        $rental = Rental::create([
            'user_id'      => Auth::id(),
            'rental_date'  => $validated['rental_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
            'total_price'  => 0,
        ]);

        $grandTotal = 0;

        // --- 4. SIMPAN DETAIL BARANG ---
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

        // Update Total Harga
        $rental->update(['total_price' => $grandTotal]);

        // Hapus Keranjang
        if (!$request->has('items')) session()->forget('cart');

        // --- 5. INTEGRASI MIDTRANS ---

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data Transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'RENTAL-' . $rental->id . '-' . rand(),
                'gross_amount' => (int) $rental->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            // Minta Snap Token
            $snapToken = Snap::getSnapToken($params);
            
            // Simpan token ke database
            $rental->snap_token = $snapToken;
            $rental->save();

            // Redirect ke halaman pembayaran (yang akan kita buat di langkah 4)
            return redirect()->route('customer.order.payment', $rental->id);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function showPayment(Rental $rental)
    {
        // 1. Cek Keamanan: Pastikan yang bayar adalah pemilik rental
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pembayaran ini.');
        }

        // 2. Cek apakah Snap Token sudah ada di database?
        // Jika belum ada, kita buatkan baru (menggunakan logika Midtrans)
        if (empty($rental->snap_token)) {
            
            // Konfigurasi Midtrans (Server Key sudah di-load oleh Middleware, 
            // tapi kita set lagi di sini untuk memastikan aman)
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = config('services.midtrans.is_sanitized');
            Config::$is3ds = config('services.midtrans.is_3ds');

            // Siapkan Parameter (Ganti data 'Yoga' & '10000' jadi Data Asli)
            $params = [
                'transaction_details' => [
                    'order_id' => $rental->id . '-' . time(), // Order ID unik (ID Rental + Timestamp)
                    'gross_amount' => (int) $rental->total_price, // Harga asli dari database
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name, // Nama user yang login
                    'email' => auth()->user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $rental->item_id,
                        'price' => (int) $rental->total_price,
                        'quantity' => 1,
                        'name' => 'Sewa Produk #' . $rental->item_id,
                    ]
                ]
            ];

            try {
                // Generate Token
                $snapToken = Snap::getSnapToken($params);

                // Simpan token ke database rental
                $rental->snap_token = $snapToken;
                $rental->save();

            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        }

        // 3. Tampilkan View (Token dikirim lewat variable $rental)
        return view('customer.order.payment', compact('rental'));
    }
    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.order.success', compact('rental'));
    }

    
}
