<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Inventory;

class HomeController extends Controller
{
    public function index()
    {
        $promos = Promo::where('is_active', true)->get();
        
        $stock = [
            'ps5' => Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%5%'); })->where('status', 'available')->count(),
            'ps4' => Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%4%'); })->where('status', 'available')->count(),
            'ps3' => Inventory::whereHas('category', function($q) { $q->where('name', 'LIKE', '%3%'); })->where('status', 'available')->count(),
        ];
        
        $nextAvailable = [
            'ps5' => $stock['ps5'] == 0 ? \App\Models\Booking::whereHas('inventory.category', function($q) { $q->where('name', 'LIKE', '%5%'); })->where('status', 'active')->min('end_time') : null,
            'ps4' => $stock['ps4'] == 0 ? \App\Models\Booking::whereHas('inventory.category', function($q) { $q->where('name', 'LIKE', '%4%'); })->where('status', 'active')->min('end_time') : null,
            'ps3' => $stock['ps3'] == 0 ? \App\Models\Booking::whereHas('inventory.category', function($q) { $q->where('name', 'LIKE', '%3%'); })->where('status', 'active')->min('end_time') : null,
        ];
        $categories = \App\Models\Category::all()->keyBy(function($item) {
            if (strpos(strtolower($item->name), '5') !== false) return 'ps5';
            if (strpos(strtolower($item->name), '4') !== false) return 'ps4';
            if (strpos(strtolower($item->name), '3') !== false) return 'ps3';
            return 'other';
        });
        
        return view('welcome', compact('promos', 'stock', 'nextAvailable', 'categories'));
    }
}
