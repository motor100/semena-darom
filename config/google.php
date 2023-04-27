<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Captcha API Key
    |--------------------------------------------------------------------------
    | 
    | https://developers.google.com/recaptcha/docs/display?hl=ru
    |
    */

    'client_key' => env('GOOGLE_CAPTCHA_CLIENT_KEY', ''),
    'server_key' => env('GOOGLE_CAPTCHA_SERVER_KEY', '')

];