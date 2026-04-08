<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class HomeController extends Controller
{
    public function index()
    {
        $promo = Promo::where('is_active', true)->first();
        return view('welcome', compact('promo'));
    }
}
