<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminRentalController;
use App\Http\Controllers\CustomerCatalogController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerRentalController;


    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('items', AdminItemController::class);
        Route::resource('categories', CategoryController::class);

        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

        Route::prefix('rentals')->name('rentals.')->group(function () {
            Route::get('/', [AdminRentalController::class, 'index'])->name('index');
            Route::get('/{rental}', [AdminRentalController::class, 'show'])->name('show');
            Route::get('/{rental}/edit', [AdminRentalController::class, 'edit'])->name('edit');
            Route::put('/{rental}', [AdminRentalController::class, 'update'])->name('update');
            Route::delete('/{rental}', [AdminRentalController::class, 'destroy'])->name('destroy');
        });
    });

Route::middleware(['auth', 'customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/', [CustomerController::class, 'index'])->name('dashboard');

        // Catalog
        Route::prefix('catalog')->name('catalog.')->group(function () {
            Route::get('/', [CustomerCatalogController::class, 'index'])->name('index');
            Route::get('/{item}', [CustomerCatalogController::class, 'show'])->name('show');
        });

        // ===== ORDER (Single Checkout) =====
        Route::get('/order/create/{item}', [CustomerOrderController::class, 'createSingle'])
            ->name('order.single');

        Route::post('/order', [CustomerOrderController::class, 'store'])
            ->name('order.store');

        Route::get('/order/success/{rental}', [CustomerOrderController::class, 'success'])
            ->name('order.success');

        //Cart
        Route::post('/cart/add/{item}', [CustomerOrderController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [CustomerOrderController::class, 'cart'])->name('cart');
        Route::delete('/cart/remove/{cartItem}', [CustomerOrderController::class, 'removeCartItem'])->name('cart.remove');
        Route::post('/cart/checkout', [CustomerOrderController::class, 'checkoutCart'])->name('cart.checkout');

        // Rentals
        Route::prefix('rentals')->name('rentals.')->group(function () {
            Route::get('/history', [CustomerController::class, 'rentalHistory'])->name('history');
            Route::get('/{rental}', [CustomerController::class, 'showRental'])->name('show');
        });

        // Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [CustomerController::class, 'editProfile'])->name('edit');
            Route::put('/update', [CustomerController::class, 'updateProfile'])->name('update');
        });

        Route::put('/password/update', [CustomerController::class, 'updatePassword'])->name('password.update');
        Route::get('artikel/cara-sewa', fn() => view('customer.artikel.carasewa'))->name('artikel.carasewa');
        Route::get('/artikel/pengembalian', function () {
            return view('customer.artikel.pengembalian');
        })->name('artikel.pengembalian');

        Route::middleware(['midtrans_config'])->group(function () {
            
            // 1. Route Generate Token (Opsional jika pakai controller showPayment)
            Route::post('/get-snap-token', [CustomerOrderController::class, 'getSnapToken']);
            
            // 2. Route Halaman Pembayaran (SUDAH DIPERBAIKI)
            // Mengarah ke Controller 'showPayment' agar data $rental & Snap Token terkirim ke view
            Route::get('/payment/{rental}', [CustomerOrderController::class, 'showPayment'])
                ->name('order.payment');
        });
    });
