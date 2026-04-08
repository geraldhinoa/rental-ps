<?php

namespace App\Http\Controllers;

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
        
        $bookings = Booking::with(['user', 'inventory'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('revenue', 'activeRentals', 'pendingBookings', 'bookings'));
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

        return view('admin.inventory', compact('ps5Count', 'ps4Count', 'ps3Count'));
    }

    public function customers()
    {
        $customers = User::where('role', 'user')->latest()->get();
        return view('admin.customers', compact('customers'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'inventory'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }
}
