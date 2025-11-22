<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Anda sudah login sebagai Admin.');
            } 
            
            return redirect()->route('customer.dashboard')
                ->with('success', 'Anda sudah login sebagai Customer.');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Berhasil masuk sebagai Admin.');
            }

            return redirect()->route('customer.dashboard')
                ->with('success', 'Berhasil masuk sebagai Customer.');
        }
        return back()
            ->withErrors(['email' => 'Kredensial tidak cocok.'])
            ->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        return redirect()->route('login');
    }
}
