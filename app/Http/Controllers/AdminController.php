<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateRequest;
use App\Models\Item;
use App\Models\User;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalItems     = Item::count();
        $activeRentals  = Rental::where('status', 'rented')->count();
        $lowStockList   = Item::where('stock', '<', 5)->get();
        $lowStockCount  = $lowStockList->count();
        $totalUsers     = User::where('role', 'customer')->count();

        $recentRentals = Rental::with(['user', 'details.item'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalItems',
            'activeRentals',
            'lowStockCount',
            'lowStockList',
            'totalUsers',
            'recentRentals'
        ));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(AdminUpdateRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('success', 'Profil Admin berhasil diperbarui!');
    }
}
