<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Promo;
use App\Models\Inventory;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $revenue = Booking::whereDate('created_at', today())->sum('total_price');
        $activeRentals = Booking::where('status', 'active')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        // Breakdown konsol yang aktif disewa
        $activePS5 = Booking::where('status', 'active')->whereHas('inventory.category', function($q) { $q->where('name', 'LIKE', '%5%'); })->count();
        $activePS4 = Booking::where('status', 'active')->whereHas('inventory.category', function($q) { $q->where('name', 'LIKE', '%4%'); })->count();
        $activePS3 = Booking::where('status', 'active')->whereHas('inventory.category', function($q) { $q->where('name', 'LIKE', '%3%'); })->count();

        $bookings = Booking::with(['user', 'inventory'])->latest()->take(10)->get();

        $totalMachines = Inventory::count();
        $availableMachines = Inventory::where('status', 'available')->count();

        // Chart Data (7 Days Revenue)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = Booking::whereDate('created_at', $date)->sum('total_price');
        }

        return view('backend.dashboard', compact('revenue', 'activeRentals', 'pendingBookings', 'bookings', 'activePS5', 'activePS4', 'activePS3', 'totalMachines', 'availableMachines', 'chartLabels', 'chartData'));
    }

    public function togglePromo(Request $request)
    {
        // Simple endpoint to toggle promo
        $promo = Promo::where('code', $request->code)->first();
        if($promo) {
            $promo->is_active = !$promo->is_active;
            $promo->save();
        }
        return back();
    }

    public function inventory()
    {
        $ps5Count = Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%5%'); })->count();
        $ps4Count = Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%4%'); })->count();
        $ps3Count = Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%3%'); })->count();
        
        $inventories = Inventory::with('category')->get();
        $categories = \App\Models\Category::all();

        return view('backend.inventory', compact('ps5Count', 'ps4Count', 'ps3Count', 'inventories', 'categories'));
    }

    public function storeInventory(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255'
        ]);

        Inventory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'status' => 'available'
        ]);

        return back()->with('success', 'Mesin berhasil ditambahkan!');
    }

    public function destroyInventory($id)
    {
        Inventory::findOrFail($id)->delete();
        return back()->with('success', 'Mesin dihapus!');
    }

    public function updatePrices(Request $request)
    {
        $prices = $request->input('prices', []);
        foreach ($prices as $categoryId => $price) {
            \App\Models\Category::where('id', $categoryId)->update(['price_per_hour' => $price]);
        }
        return back()->with('success', 'Harga sewa berhasil diperbarui!');
    }

    public function promos()
    {
        $promos = Promo::latest()->get();
        return view('backend.promos', compact('promos'));
    }

    public function storePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promos|max:50',
            'discount_amount' => 'required|numeric',
            'description' => 'required|string|max:255'
        ]);

        Promo::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_amount' => $request->discount_amount,
            'is_active' => true
        ]);

        return back()->with('success', 'Voucher Promo berhasil dibuat!');
    }

    public function destroyPromo($id)
    {
        Promo::findOrFail($id)->delete();
        return back()->with('success', 'Voucher Promo berhasil dihapus!');
    }

    public function customers()
    {
        $customers = User::where('role', 'user')->latest()->get();
        return view('backend.customers', compact('customers'));
    }

    public function destroyCustomer($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Data pelanggan berhasil dihapus!');
    }

    public function bulkDestroyCustomers(Request $request)
    {
        $ids = $request->input('customer_ids');
        if ($ids && is_array($ids)) {
            User::whereIn('id', $ids)->delete();
            return back()->with('success', count($ids) . ' data pelanggan berhasil dihapus!');
        }
        return back()->with('error', 'Pilih setidaknya satu pelanggan untuk dihapus!');
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'inventory'])->latest()->get();
        $inventories = Inventory::all();
        return view('backend.bookings', compact('bookings', 'inventories'));
    }

    public function processBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status === 'pending') {
            // Hitung sisa durasi dari pesanan aslinya
            $oldStart = \Carbon\Carbon::parse($booking->start_time);
            $oldEnd = \Carbon\Carbon::parse($booking->end_time);
            $durationInSeconds = abs($oldEnd->diffInSeconds($oldStart));

            // Sesuaikan waktu mulai dengan waktu aktual saat ditekan "Proses"
            $booking->start_time = now();
            $booking->end_time = now()->addSeconds($durationInSeconds);
            
            $booking->status = 'active';
            $booking->save();

            // Jika pelanggan bayar di kasir, saat diproses anggap sudah lunas
            if ($booking->payment && $booking->payment->payment_status === 'pending') {
                $booking->payment->update(['payment_status' => 'success']);
            }

            // Kunci stok inventaris agar tidak bisa disewa orang lain
            if ($booking->inventory) {
                $booking->inventory->status = 'rented';
                $booking->inventory->save();
            }

            // --- FITUR NOTIFIKASI WA (DINONAKTIFKAN SEMENTARA UNTUK DEMO UAS) ---
            // $target = $booking->user->phone_number;
            // $name = $booking->user->name;
            // $unit = $booking->inventory ? $booking->inventory->unit_name : 'Konsol';
            // $duration = $booking->pricingPackage ? $booking->pricingPackage->duration_hours : 'beberapa';
            // 
            // $waMessage = "*GAMEZONE RENTAL*\n\n"
            //            . "Halo $name! Pesanan kamu sudah kami ACC dan waktu bermain kamu selama $duration Jam sudah MULAI BERJALAN sekarang juga.\n\n"
            //            . "Silakan langsung menuju ke *$unit* dan nikmati permainanmu!\n\n"
            //            . "Selamat bermain!";
            // 
            // \App\Services\FonnteService::send($target, $waMessage);
            // ----------------------------------------------------------------------
        }
        return back()->with('success', 'Pesanan berhasil diproses, waktu berjalan, dan pembayaran ditandai lunas!');
    }

    public function finishBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status === 'active') {
            $booking->status = 'completed';
            $booking->save();

            // Bebaskan stok inventaris kembali
            if ($booking->inventory) {
                $booking->inventory->status = 'available';
                $booking->inventory->save();
            }
        }
        return back()->with('success', 'Penyewaan selesai dan mesin kembali tersedia.');
    }

    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        // Free inventory if it was active
        if ($booking->status === 'active' && $booking->inventory) {
            $booking->inventory->status = 'available';
            $booking->inventory->save();
        }
        $booking->delete();
        return back()->with('success', 'Pesanan berhasil dihapus!');
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate([
            'inventory_id' => 'nullable|exists:inventories,id',
            'status' => 'required|in:pending,active,completed,cancelled'
        ]);

        // Handle inventory logic if status changes
        if ($booking->status !== $request->status) {
            if ($request->status === 'active' && $booking->inventory_id) {
                $inv = Inventory::find($booking->inventory_id);
                if($inv) { $inv->status = 'rented'; $inv->save(); }
            } elseif ($booking->status === 'active') {
                // Changing from active to something else
                if ($booking->inventory) {
                    $booking->inventory->status = 'available';
                    $booking->inventory->save();
                }
            }
        }

        $booking->update([
            'inventory_id' => $request->inventory_id,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Pesanan berhasil diperbarui!');
    }
}
