<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

// UI Publik
Route::get('/', [HomeController::class, 'index']);

// Pemesanan
Route::get('/booking', [BookingController::class, 'create']);
Route::post('/booking', [BookingController::class, 'store']);

// Autentikasi
Route::get('/login', function () {
    if(Auth::check() && Auth::user()->role === 'admin') return redirect('/admin/dashboard');
    return view('auth.login');
})->name('login');

Route::post('/login', function(Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        if(Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        Auth::logout();
        return back()->with('error', 'Akun Anda bukan Admin.');
    }
    return back()->with('error', 'Email atau Kata Sandi salah!');
});

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
});

// Area Admin (Dilindungi)
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::post('/admin/promo/toggle', [AdminController::class, 'togglePromo']);
    
    // Fitur Manajemen
    Route::get('/admin/bookings', [AdminController::class, 'bookings']);
    Route::get('/admin/inventory', [AdminController::class, 'inventory']);
    Route::get('/admin/customers', [AdminController::class, 'customers']);
});
