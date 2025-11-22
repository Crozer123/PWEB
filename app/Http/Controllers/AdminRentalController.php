<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateRentalRequest;

class AdminRentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        // Pastikan relasi details.item dimuat untuk akses stok
        $rental->load('details.item', 'user');
        return view('admin.rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        return view('admin.rentals.edit', compact('rental'));
    }

    public function update(UpdateRentalRequest $request, Rental $rental)
    {
        $old = $rental->status;
        $new = $request->status;

        // KASUS 1: Barang Dikembalikan (Rented -> Returned)
        if ($new === 'returned' && $old !== 'returned') {
            foreach ($rental->details as $detail) {
                $detail->item->increment('stock', $detail->quantity);
            }
            $rental->returned_at = now();
        }

        // KASUS 2: Admin Membatalkan Pesanan (Pending/Rented -> Canceled)
        // Menggunakan 'canceled' (satu L) sesuai database
        if ($new === 'canceled' && $old !== 'canceled') {
            foreach ($rental->details as $detail) {
                $detail->item->increment('stock', $detail->quantity);
            }
        }

        $rental->update([
            'status' => $new
        ]);

        return redirect()
            ->route('admin.rentals.index')
            ->with('success', 'Status rental berhasil diperbarui.');
    }

    public function destroy(Rental $rental)
    {
        // PERBAIKAN DISINI: Ganti 'active' jadi 'rented'
        if (in_array($rental->status, ['pending', 'rented'])) {
            foreach ($rental->details as $detail) {
                $detail->item->increment('stock', $detail->quantity);
            }
        }

        $rental->delete();

        return back()->with('success', 'Rental berhasil dihapus (diarsipkan).');
    }
}