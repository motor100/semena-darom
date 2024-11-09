<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SDEK API Key
    |--------------------------------------------------------------------------
    | 
    | https://otpravka.pochta.ru/specification#/authorization-token
    |
    */

    'application_token' => env('RUSSIANPOST_APPLICATION_TOKEN', ''),
    'user_key' => env('RUSSIANPOST_USER_KEY', '')

];