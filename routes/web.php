<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Middleware\AdminMiddleware;

// === FRONTEND ROUTES ===

// UI Publik
Route::get('/', [HomeController::class, 'index']);

// Pemesanan
Route::get('/booking', [BookingController::class, 'create']);
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/booking/{id}/receipt', [BookingController::class, 'receipt'])->name('booking.receipt');
Route::post('/payment/simulate/{id}', [BookingController::class, 'simulatePayment'])->name('payment.simulate');
Route::any('/payment/finish', [BookingController::class, 'finishPayment'])->name('payment.finish');

// Utility untuk clear cache di Hosting
Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return 'Cache berhasil dibersihkan! Silakan kembali ke website.';
});

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function(Request $request) {
        $user = \App\Models\User::where('email', $request->email)
                                ->orWhere('phone_number', $request->email)
                                ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            if ($user->role === 'admin') {
                Auth::login($user);
                return redirect('/admin/dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }
            Auth::login($user);
            return redirect('/user/dashboard');
        }
        return back()->with('error', 'Email/No WA atau Kata Sandi salah!');
    });

    Route::get('/admin/login', function () {
        return view('auth.admin_login');
    })->name('admin.login');

    Route::post('/admin/login', function(Request $request) {
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && $user->role === 'admin' && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/admin/dashboard');
        }
        return back()->with('error', 'Kredensial Admin tidak valid!');
    });

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email ini sudah terdaftar! Silakan kembali dan pilih menu "Masuk" (Login).',
            'phone_number.unique' => 'Nomor WhatsApp ini sudah terdaftar! Silakan kembali dan pilih menu "Masuk".',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.'
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email ?? $request->phone_number . '@guest.gamezone.com',
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);
        return redirect('/user/dashboard');
    });

    // Google OAuth
    Route::get('/auth/google', function () {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    })->name('google.login');

    Route::get('/auth/google/callback', function () {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

            $user = \App\Models\User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            // Jika Admin masuk lewat pintu Pelanggan, arahkan langsung ke Dasbor Admin (Lebih ramah UX)
            if ($user && $user->role === 'admin') {
                Auth::login($user);
                return redirect('/admin/dashboard')->with('success', 'Selamat datang kembali, Admin! (Masuk via Google)');
            }

            if (!$user) {
                // Register new user
                $user = \App\Models\User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    // Use a random password since they login with Google
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
                    'role' => 'user',
                ]);
            } else {
                // Update existing user with google_id if missing
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                }
            }

            Auth::login($user);
            return redirect('/user/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    });

    // --- Reset Password ---
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = \Illuminate\Support\Facades\Password::sendResetLink($request->only('email'));
        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? back()->with(['status' => 'Link reset kata sandi telah dikirim ke email Anda.'])
                    : back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.']);
    })->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        
        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password)
                ])->setRememberToken(\Illuminate\Support\Str::random(60));
                $user->save();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect('/login')->with('status', 'Kata sandi berhasil direset! Silakan login dengan kata sandi baru.')
                    : back()->withErrors(['email' => 'Token reset kata sandi tidak valid atau kadaluarsa.']);
    })->name('password.update');

});

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
});

// Area Pelanggan (Dilindungi)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [\App\Http\Controllers\Frontend\UserController::class, 'dashboard'])->name('user.dashboard');
});

// === BACKEND ROUTES ===
// Area Admin (Dilindungi)
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::post('/admin/promo/toggle', [AdminController::class, 'togglePromo']);
    
    // Fitur Manajemen
    Route::get('/admin/api/notifications', function() {
        $bookings = \App\Models\Booking::with('user')->where('status', 'pending')->latest()->take(5)->get()->map(function($b) {
            $type = \Carbon\Carbon::parse($b->start_time)->diffInHours(\Carbon\Carbon::parse($b->end_time)) >= 24 ? 'BAWA PULANG' : 'DI TEMPAT';
            return [
                'id' => $b->id,
                'name' => $b->user->name ?? 'Guest',
                'type' => $type,
                'trx' => 'TRX-0' . ($b->id * 100),
                'time' => $b->created_at->diffForHumans()
            ];
        });
        return response()->json([
            'count' => \App\Models\Booking::where('status', 'pending')->count(),
            'bookings' => $bookings
        ]);
    });
    
    Route::get('/admin/bookings', [AdminController::class, 'bookings']);
    Route::post('/admin/bookings/{id}/process', [AdminController::class, 'processBooking'])->name('admin.bookings.process');
    Route::post('/admin/bookings/{id}/finish', [AdminController::class, 'finishBooking'])->name('admin.bookings.finish');
    Route::put('/admin/bookings/{id}', [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{id}', [AdminController::class, 'destroyBooking'])->name('admin.bookings.destroy');
    
    // Inventory CRUD
    Route::get('/admin/inventory', [AdminController::class, 'inventory']);
    Route::post('/admin/inventory', [AdminController::class, 'storeInventory']);
    Route::post('/admin/inventory/prices', [AdminController::class, 'updatePrices']);
    Route::delete('/admin/inventory/{id}', [AdminController::class, 'destroyInventory']);
    
    // Promo CRUD
    Route::get('/admin/promos', [AdminController::class, 'promos']);
    Route::post('/admin/promos', [AdminController::class, 'storePromo']);
    Route::delete('/admin/promos/{id}', [AdminController::class, 'destroyPromo']);

    Route::get('/admin/customers', [AdminController::class, 'customers']);
    Route::delete('/admin/customers/bulk', [AdminController::class, 'bulkDestroyCustomers'])->name('admin.customers.bulkDestroy');
    Route::delete('/admin/customers/{id}', [AdminController::class, 'destroyCustomer'])->name('admin.customers.destroy');
});
