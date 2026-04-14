<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class HomeController extends Controller
{
    public function index()
    {
        $promo = Promo::where('is_active', true)->first();
        
        // Cek ketersediaan stok mesin PS
        $ps5_available = \App\Models\Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%5%'); })->where('status', 'available')->exists();
        $ps4_available = \App\Models\Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%4%'); })->where('status', 'available')->exists();
        $ps3_available = \App\Models\Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%3%'); })->where('status', 'available')->exists();

        return view('welcome', compact('promo', 'ps5_available', 'ps4_available', 'ps3_available'));
    }
}
