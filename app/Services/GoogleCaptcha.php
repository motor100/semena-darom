<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleCaptcha
{
    protected $validated;

    public function __construct($validated)
    {
        $this->validated = $validated;
    }

    public function get()
    {
        // Google Captcha
        $g_url = 'https://www.google.com/recaptcha/api/siteverify';

        $g_params = [
            'secret' => config('google.server_key'),
            'response' => $this->validated["g-recaptcha-response"],
        ];

        $g_response = Http::asForm()->post($g_url, $g_params);

        return $g_response->json('success') ? '$g_response' : false;
    }

}