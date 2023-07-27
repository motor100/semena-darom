<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use App\Models\City;

class PostalCode
{
    public function get()
    { 
        // Получение почтового индекса
        // Получение куки через фасад Cookie метод get
        $cookie_city = json_decode(Cookie::get('city'), true);

        if ($cookie_city) {
            $city = City::find($cookie_city["id"]);
            return $city->postal_code;
        } else {
            // По умолчанию почтовый код Москвы
            return 101000;
        }
    }
}