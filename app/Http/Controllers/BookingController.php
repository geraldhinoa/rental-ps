<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Inventory;
use App\Models\PricingPackage;
use App\Models\Promo;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create()
    {
        $promos = Promo::where('is_active', true)->get();
        return view('user.booking', compact('promos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'rental_type' => 'required|in:main_di_tempat,bawa_pulang',
            'unit' => 'required',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'promo_code' => 'nullable|string'
        ]);

        // Cek Promo
        $discount = 0;
        if($request->promo_code) {
            $promo = Promo::where('code', strtoupper($request->promo_code))->where('is_active', true)->first();
            if($promo) {
                $discount = $promo->discount_amount;
            }
        }

        // Hitung Harga
        $rate = 4000;
        $categoryMatch = '3'; // PlayStation 3
        
        if($request->unit == 'ps5') {
            $rate = ($request->rental_type === 'bawa_pulang') ? 200000 : 10000;
            $categoryMatch = '5';
        } elseif($request->unit == 'ps4') {
            $rate = ($request->rental_type === 'bawa_pulang') ? 100000 : 6000;
            $categoryMatch = '4';
        } else {
            // PS3
            $rate = ($request->rental_type === 'bawa_pulang') ? 50000 : 4000;
            $categoryMatch = '3';
        }
        
        $totalPrice = ($rate * $request->duration) - $discount;
        if($totalPrice < 0) $totalPrice = 0;

        // User Guest
        $user = User::firstOrCreate(
            ['phone_number' => $request->phone],
            [
                'name' => $request->name, 
                'email' => $request->phone . '@guest.gamezone.com',
                'role' => 'user', 
                'password' => bcrypt(Str::random(10))
            ]
        );

        // Inventory lookup (Cari konsol berdasarkan angka 3, 4, atau 5)
        $inventory = Inventory::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->where('status', 'available')->first() 
        ?? Inventory::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->first() 
        ?? Inventory::first(); // Fallback Ekstrim

        // Pricing lookup mock
        $package = PricingPackage::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->first() ?? PricingPackage::first();

        // Hitung Waktu
        $addTime = ($request->rental_type === 'bawa_pulang') 
            ? ' + ' . $request->duration . ' days' 
            : ' + ' . $request->duration . ' hours';

        $booking = Booking::create([
            'user_id' => $user->id,
            'inventory_id' => $inventory->id, 
            'pricing_package_id' => $package->id,
            'start_time' => $request->start_time,
            'end_time' => date('Y-m-d H:i:s', strtotime($request->start_time . $addTime)),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'payment_method' => strtoupper($request->payment_method),
            'amount' => $totalPrice,
            'payment_status' => 'pending',
            'transaction_reference' => 'TRX-' . strtoupper(Str::random(6)),
        ]);

        return redirect('/booking')->with('success', 'Pesanan berhasil dibuat! Silakan hubungi admin di WA jika ada kendala.');
    }
}
