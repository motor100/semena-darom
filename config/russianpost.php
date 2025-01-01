<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CDEK API Key
    |--------------------------------------------------------------------------
    | 
    | https://otpravka.pochta.ru/specification#/authorization-token
    |
    */

    'login' => env('RUSSIANPOST_LOGIN', ''),
    'password' => env('RUSSIANPOST_PASSWORD', ''),
    'access_token' => env('RUSSIANPOST_ACCESS_TOKEN', '')

];