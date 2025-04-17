<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WablasService
{
    protected $apiKey;
    protected $device;

    public function __construct()
    {
        $this->apiKey = config('services.wablas.api_key');
        $this->device = config('services.wablas.device');
    }

    public function send($phone, $message)
    {
        // Example implementation for sending a message via Wablas API
        $response = Http::post('https://wablas.com/api/send-message', [
            'phone' => $phone,
            'message' => $message,
            'api_key' => env('WABLAS_API_KEY'), // Ensure you have this in your .env file
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to send WhatsApp message.');
        }

        return $response->json();
    }
}
