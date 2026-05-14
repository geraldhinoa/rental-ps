<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $target Phone number
     * @param string $message Message content
     * @return bool
     */
    public static function send($target, $message)
    {
        $token = env('FONNTE_TOKEN');
        
        // Return true / mock if no token is configured
        if (!$token || $token == 'your_fonnte_token_here') {
            Log::info("Fonnte Simulation Message to {$target}: \n{$message}");
            return true;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Default Indonesia
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error("Fonnte Error: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Fonnte Exception: " . $e->getMessage());
            return false;
        }
    }
}
