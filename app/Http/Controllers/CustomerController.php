<?php

namespace App\Http\Controllers;

use App\Models\Rental; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use App\Http\Requests\UpdateProfileRequest; 
use App\Http\Requests\updatePasswordRequest; 


class CustomerController extends Controller
{
    public function index()
    {
        $activeRentals = Rental::where('user_id', Auth::id())
            ->where('status', 'active')
            ->count();
        $recentRentals = Rental::where('user_id', Auth::id())
            ->with('details.item') 
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('activeRentals', 'recentRentals'));
    }

    public function rentalHistory()
    {
        $rentals = Rental::where('user_id', Auth::id())
            ->with('details.item')
            ->latest()
            ->paginate(10);

        return view('customer.rentals.history', compact('rentals')); 
    }

    public function showRental(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }
        $rental->load('details.item');
        return view('customer.rentals.show', compact('rental')); 
    }

    public function editProfile()
    {
        return view('customer.profile'); 
    }

    public function updateProfile(UpdateProfileRequest $request) 
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save(); 

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(updatePasswordRequest $request) 
    {
        $user = Auth::user();
        
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function orderList()
    {
        $rentals = Auth::user()->rentals()->with('details.item')->latest()->get();

        return view('customer.orders.index', compact('rentals'));
    }

    public function orderDetail(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $rental->load('details.item'); 
        return view('customer.orders.detail', compact('rental'));
    }
}