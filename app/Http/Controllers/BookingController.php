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
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $promos = Promo::where('is_active', true)->get();
        $stock = [
            'ps5' => Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%5%'); })->where('status', 'available')->count(),
            'ps4' => Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%4%'); })->where('status', 'available')->count(),
            'ps3' => Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%3%'); })->where('status', 'available')->count(),
        ];
        return view('user.booking', compact('promos', 'stock'));
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

        $userId = null;
        if (Auth::check()) {
            $userId = Auth::id();
            // Update phone number if it's missing or different, but don't overwrite email/password
            $user = Auth::user();
            if (!$user->phone_number) {
                $user->update(['phone_number' => $request->phone]);
            }
        } else {
            // User Guest
            $user = User::firstOrCreate(
                ['phone_number' => $request->phone],
                [
                    'name' => $request->name, 
                    'email' => $request->phone . '@guest.gamezone.com',
                    'role' => 'user', 
                    'password' => bcrypt($request->phone)
                ]
            );
            $userId = $user->id;
            Auth::login($user);
        }

        // Inventory lookup (Cari konsol berdasarkan angka 3, 4, atau 5)
        $inventory = Inventory::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->where('status', 'available')->first();

        // Jika konsol tidak tersedia, kembalikan dengan error
        if (!$inventory) {
            return back()->withInput()->with('error', 'ps masih penuh , mohon di tunggu 🙏');
        }

        // Pricing lookup mock
        $package = PricingPackage::whereHas('category', function($q) use ($categoryMatch) {
            $q->where('name', 'LIKE', '%'.$categoryMatch.'%');
        })->first() ?? PricingPackage::first();

        // Hitung Waktu
        $addTime = ($request->rental_type === 'bawa_pulang') 
            ? ' + ' . $request->duration . ' days' 
            : ' + ' . $request->duration . ' hours';

        $booking = Booking::create([
            'user_id' => $userId,
            'inventory_id' => $inventory->id, 
            'pricing_package_id' => $package->id,
            'start_time' => $request->start_time,
            'end_time' => date('Y-m-d H:i:s', strtotime($request->start_time . $addTime)),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $paymentStatus = 'pending'; // Simulasi: Menunggu Webhook Payment Gateway

        $trxId = 'TRX-' . strtoupper(Str::random(6));
        Payment::create([
            'booking_id' => $booking->id,
            'payment_method' => strtoupper($request->payment_method),
            'amount' => $totalPrice,
            'payment_status' => $paymentStatus,
            'transaction_reference' => $trxId,
        ]);

        // Send WhatsApp Notification to Customer
        $customerMessage = "*GAMEZONE RENTAL PS*\n\n" .
            "Halo {$request->name},\n" .
            "Terima kasih telah melakukan pemesanan! Berikut rinciannya:\n\n" .
            "🎮 Unit: " . strtoupper($request->unit) . "\n" .
            "⏱️ Waktu Mulai: " . date('d M Y, H:i', strtotime($request->start_time)) . "\n" .
            "⏳ Durasi: {$request->duration} " . ($request->rental_type === 'bawa_pulang' ? 'Hari' : 'Jam') . "\n" .
            "💰 Total Biaya: Rp " . number_format($totalPrice, 0, ',', '.') . "\n" .
            "💳 Pembayaran: " . strtoupper($request->payment_method) . "\n\n" .
            "Harap tunjukkan pesan ini saat kedatangan. Selamat bermain! 🎮";
        
        \App\Services\FonnteService::send($request->phone, $customerMessage);

        // Send WhatsApp Notification to Admin
        $adminPhone = env('ADMIN_WHATSAPP', '085899202340');
        $adminMessage = "🔔 *PESANAN BARU MASUK!*\n\n" .
            "👤 Pelanggan: {$request->name}\n" .
            "📱 WA: {$request->phone}\n" .
            "🎮 Unit: " . strtoupper($request->unit) . "\n" .
            "⏱️ Mulai: " . date('d M Y, H:i', strtotime($request->start_time)) . "\n" .
            "💵 Total: Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n" .
            "Cek dasbor admin segera!";
            
        \App\Services\FonnteService::send($adminPhone, $adminMessage);

        return redirect()->route('booking.receipt', ['id' => $booking->id])->with('success', '✅ BERHASIL! Pesanan Anda telah terkonfirmasi.');
    }

    public function receipt($id)
    {
        $booking = Booking::with(['payment', 'user', 'inventory.category'])->findOrFail($id);
        
        $snapToken = null;
        if ($booking->payment->payment_status === 'pending' && $booking->payment->payment_method === 'OTOMATIS') {
            // Menggunakan Server Key yang diberikan user
            $serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-YOURKEY'); 
            
            $payload = [
                'transaction_details' => [
                    'order_id' => $booking->payment->transaction_reference . '-' . time(), // Tambah time() untuk mencegah order_id duplikat di Midtrans
                    'gross_amount' => (int) $booking->payment->amount,
                ],
                'customer_details' => [
                    'first_name' => $booking->user->name,
                    'email' => $booking->user->email ?? 'guest@gamezone.com',
                    'phone' => $booking->user->phone_number ?? '08000000000',
                ],
                'callbacks' => [
                    'finish' => url('/payment/finish?order_id=' . $booking->payment->transaction_reference),
                    'unfinish' => url('/payment/finish?order_id=' . $booking->payment->transaction_reference),
                    'error' => url('/payment/finish?order_id=' . $booking->payment->transaction_reference),
                ]
            ];

            $ch = curl_init('https://app.sandbox.midtrans.com/snap/v1/transactions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($serverKey . ':')
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response);
            if (isset($result->token)) {
                $snapToken = $result->token;
            }
        }

        return view('user.receipt', compact('booking', 'snapToken'));
    }

    public function simulatePayment($id)
    {
        $payment = Payment::where('booking_id', $id)->firstOrFail();
        $payment->update([
            'payment_status' => 'success'
        ]);

        return redirect()->route('booking.receipt', ['id' => $id])->with('success', 'Pembayaran berhasil dikonfirmasi secara otomatis via Payment Gateway Simulasi!');
    }

    public function finishPayment(Request $request)
    {
        \Log::info('Midtrans Callback Data:', $request->all());

        $orderId = $request->order_id ?? $request->transaction_id;
        if (!$orderId) {
            // Coba lihat apakah Midtrans naruh di tempat lain
            return redirect('/user/dashboard');
        }

        // Midtrans mengirim order_id contoh: TRX-ABCDEF-1715494291
        $parts = explode('-', $orderId);
        if (count($parts) >= 2) {
            $baseTrx = $parts[0] . '-' . $parts[1];
            $payment = Payment::where('transaction_reference', $baseTrx)->first();
            
            if ($payment) {
                $payment->update(['payment_status' => 'success']);
                return redirect()->route('booking.receipt', ['id' => $payment->booking_id])->with('success', 'Pembayaran berhasil dikonfirmasi secara otomatis via Midtrans!');
            }
        }
        
        return redirect('/user/dashboard');
    }
}
