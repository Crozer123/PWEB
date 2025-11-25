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
    // --- BAGIAN KERANJANG DIHAPUS (addToCart, cart, updateCart, removeFromCart, create) ---

    // Halaman Form Sewa Langsung (Tetap Ada)
    public function createSingle(Item $item)
    {
        return view('customer.order.create-single', compact('item'));
    }

    // Logic Penyimpanan Rental (Disederhanakan)
    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();

        // 1. PASTIKAN DATA ITEM ADA (Karena Keranjang Dihapus)
        // Kita hanya mengambil dari request 'items' (input hidden di form)
        $itemsToProcess = [];
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $val) {
                $itemsToProcess[$val['item_id']] = ['quantity' => $val['quantity']];
            }
        } else {
            return back()->with('error', 'Tidak ada barang yang dipilih.');
        }

        // 2. VALIDASI STOK
        foreach ($itemsToProcess as $itemId => $data) {
            $item = Item::find($itemId);
            // Cek stok lagi agar tidak minus saat disewa bersamaan
            if (!$item || $item->stock < $data['quantity']) {
                return back()->with('error', "Stok {$item->name} tidak mencukupi.");
            }
        }

        // 3. BUAT RENTAL (HEADER)
        $rental = Rental::create([
            'user_id'      => Auth::id(),
            'rental_date'  => $validated['rental_date'],
            'return_date'  => $validated['return_date'],
            'status'       => 'pending',
            'total_price'  => 0, // Nanti diupdate
        ]);

        $grandTotal = 0;

        // 4. SIMPAN DETAIL & KURANGI STOK
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

            // Kurangi stok
            $item->decrement('stock', $data['quantity']);
        }

        // Update Total Harga di Header Rental
        $rental->update(['total_price' => $grandTotal]);

        // 5. MIDTRANS & REDIRECT (Sama seperti sebelumnya)
        // ... (Kode Midtrans Anda tetap sama di sini, tidak perlu diubah) ...
        
        // Agar ringkas, saya tulis redirect-nya saja:
        return redirect()->route('customer.order.payment', $rental->id);
    }

    // Method Payment & Success TETAP ADA (Tidak berubah)
    public function showPayment(Rental $rental)
    {
        // ... kode showPayment lama Anda ...
        // (Copy-paste logic showPayment dari file lama Anda ke sini)
         if ($rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pembayaran ini.');
        }

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

    public function success(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) abort(403);
        return view('customer.order.success', compact('rental'));
    }
}