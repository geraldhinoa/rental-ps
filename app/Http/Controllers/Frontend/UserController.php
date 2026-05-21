<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        $bookings = Booking::where('user_id', $user->id)
                            ->with(['inventory.category', 'payment'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('frontend.dashboard', compact('user', 'bookings'));
    }
}
