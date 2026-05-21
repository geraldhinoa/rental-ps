<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists based on email or google_id
            $user = User::where('email', $googleUser->email)->orWhere('google_id', $googleUser->id)->first();

            if ($user) {
                // If user exists, just update their google_id and avatar if they are empty
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
            } else {
                // If user does not exist, create a new one
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null, // No password since they login via Google
                    'role' => 'user', // Default role
                ]);
            }

            Auth::login($user);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil masuk dengan Google.');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'Berhasil masuk dengan Google.');
            }

        } catch (Exception $e) {
            // Log error or handle it
            return redirect('/login')->with('error', 'Gagal masuk dengan Google. Silakan coba lagi.');
        }
    }
}
