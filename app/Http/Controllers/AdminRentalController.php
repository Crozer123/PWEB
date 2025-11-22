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

        if ($new === 'active' && $old !== 'active') {
            foreach ($rental->details as $detail) {
                $detail->item->decrement('stock', $detail->quantity);
            }
        }

        if ($new === 'returned' && $old !== 'returned') {
            foreach ($rental->details as $detail) {
                $detail->item->increment('stock', $detail->quantity);
            }

            $rental->returned_at = now();
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
        if (in_array($rental->status, ['pending', 'active'])) {
            foreach ($rental->details as $detail) {
                $detail->item->increment('stock', $detail->quantity);
            }
        }

        $rental->delete();

        return back()->with('success', 'Rental berhasil dihapus (diarsipkan).');
    }
}
