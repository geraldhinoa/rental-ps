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
        // 1. VALIDASI DATA & FILE STRUK
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'rental_type' => 'required|in:main_di_tempat,bawa_pulang',
            'unit' => 'required',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'promo_code' => 'nullable|string',
            'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg|max:5048' // Validasi Struk Maksimal 5MB
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

        // 2. PERBAIKAN BUG DATABASE: Menambahkan 'name' ke nilai default agar tidak error
        $user = User::firstOrCreate(
            ['phone_number' => $request->phone],
            [
                'name' => $request->name, // INI SOLUSI ERRORNYA
                'email' => $request->phone . '@guest.gamezone.com',
                'role' => 'user', 
                'password' => bcrypt(Str::random(10))
            ]
        );
        
        // Memastikan nama selalu update sesuai inputan terbaru walau nomor HP sama
        $user->update(['name' => $request->name]);

        // Inventory lookup (Cari konsol berdasarkan angka 3, 4, atau 5)
        $inventory = Inventory::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->where('status', 'available')->first() 
        ?? Inventory::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->first() 
        ?? Inventory::first(); // Fallback Ekstrim

        // Jika database masih benar-benar kosong, buatkan data dummy otomatis
        if (!$inventory) {
            $category = \App\Models\Category::firstOrCreate(
                ['name' => 'PlayStation ' . $categoryMatch],
                ['description' => 'Console PS' . $categoryMatch]
            );
            $inventory = Inventory::create([
                'category_id' => $category->id,
                'unit_code' => 'PS' . $categoryMatch . '-' . rand(100, 999),
                'status' => 'available'
            ]);
        }

        // Pricing lookup mock
        $package = PricingPackage::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->first() ?? PricingPackage::first();

        if (!$package) {
            $package = PricingPackage::create([
                'category_id' => $inventory->category_id,
                'name' => 'Paket Rental PS' . $categoryMatch,
                'duration_hours' => 1,
                'price' => $rate
            ]);
        }

        // Hitung Waktu Akhir
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

        // 3. LOGIKA UPLOAD GAMBAR STRUK
        $receiptFileName = null;
        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $receiptFileName = time() . '_struk_' . $file->getClientOriginalName();
            
            // Menyimpan file fisik ke folder public/receipts
            $file->move(public_path('receipts'), $receiptFileName);
        }

        Payment::create([
            'booking_id' => $booking->id,
            'payment_method' => strtoupper($request->payment_method),
            'amount' => $totalPrice,
            'payment_status' => 'pending',
            'transaction_reference' => 'TRX-' . strtoupper(Str::random(6)),
            
            // Catatan: Jika kamu SUDAH menambahkan kolom 'receipt_path' di tabel payments,
            // hapus tanda komentar (//) pada baris di bawah ini:
            // 'receipt_path' => $receiptFileName 
        ]);

        return redirect('/booking')->with('success', 'Pesanan berhasil dibuat! Silakan hubungi admin di WA jika ada kendala.');
    }
}