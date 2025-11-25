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
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal

class CustomerOrderController extends Controller
{
    // ==========================================================
    // BAGIAN 1: FITUR LAMA (Sewa Langsung & Pembayaran)
    // ==========================================================

    // TAMBAHKAN INI: Method untuk Halaman "Pesanan Saya"
    public function index()
    {
        // Ubah ->get() menjadi ->paginate(10)
        $rentals = Rental::with(['details.item']) // Load relasi details dan item
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10); // Gunakan paginate agar ->links() di view berjalan

        return view('customer.order.index', compact('rentals'));
    }

    // Halaman Form Sewa Langsung (Single Item)
    public function createSingle(Item $item)
    {
        return view('customer.order.create-single', compact('item'));
    }

    // Proses Simpan Sewa (Dari Sewa Langsung)
    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();

        // --- HITUNG DURASI HARI ---
        $rentalDate = Carbon::parse($validated['rental_date']);
        $returnDate = Carbon::parse($validated['return_date']);
        // Menghitung selisih hari + 1 (agar hari pertama dihitung)
        $days = $rentalDate->diffInDays($returnDate) + 1;
        // --------------------------

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
            
            // Perbaiki Rumus: Harga x Jumlah x Durasi Hari
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

        // Update Total
        $rental->update(['total_price' => $grandTotal]);

        // Redirect ke halaman pembayaran
        return redirect()->route('customer.order.payment', $rental->id);
    }

    // Halaman Pembayaran (Midtrans)
    public function showPayment(Rental $rental)
    {
        // Pastikan user yang akses adalah pemilik rental
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pembayaran ini.');
        }

        // Jika status sudah bukan pending (misal sudah lunas), redirect balik
        if ($rental->status !== 'pending' && $rental->payment_status === 'paid') {
            return redirect()->route('customer.dashboard')
                ->with('info', 'Transaksi ini sudah dibayar.');
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
                'enabled_payments' => [
                    'bca_va', 'bni_va', 'bri_va', 'permata_va', // Virtual Account Bank
                    'gopay', 'shopeepay', 'qris'               // E-Wallet
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

        // --- HITUNG DURASI HARI ---
        $rentalDate = Carbon::parse($request->rental_date);
        $returnDate = Carbon::parse($request->return_date);
        $days = $rentalDate->diffInDays($returnDate) + 1;
        // --------------------------

        $grandTotal = 0;
        foreach ($cart->items as $ci) {
            if ($ci->item->stock < $ci->quantity) {
                return back()->with('error', "Stok untuk {$ci->item->name} tidak mencukupi.");
            }
            // Perbaiki Rumus: Harga x Jumlah x Durasi Hari
            $grandTotal += $ci->item->rental_price * $ci->quantity * $days;
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
                // Perbaiki Rumus: Harga x Jumlah x Durasi Hari
                'subtotal_price' => $ci->item->rental_price * $ci->quantity * $days
            ]);

            // Kurangi Stok Barang
            $ci->item->decrement('stock', $ci->quantity);
        }

        // Kosongkan Keranjang
        $cart->items()->delete();

        // Redirect ke Pembayaran
        return redirect()->route('customer.order.payment', $rental->id);
    }

    // ==========================================================
    // BAGIAN 3: PROSES PEMBAYARAN COD (BARU DITAMBAHKAN)
    // ==========================================================

    /**
     * Memproses pilihan pembayaran COD.
     */
    public function processCod(Request $request, Rental $rental)
    {
        // 1. Validasi Kepemilikan
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Validasi Status (Hanya bisa jika status masih pending)
        if ($rental->status !== 'pending') {
            return back()->with('error', 'Status pesanan tidak valid untuk perubahan metode pembayaran.');
        }

        // 3. Update Data Rental
        $rental->update([
            'payment_method' => 'cod', // Set metode ke COD
            // Status biarkan 'pending' karena menunggu konfirmasi admin saat barang diambil
        ]);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('customer.dashboard')
            ->with('success', 'Metode pembayaran COD berhasil dipilih. Silakan lakukan pembayaran tunai saat mengambil barang di toko.');
    }
}