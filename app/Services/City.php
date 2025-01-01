<?php

namespace App\Services;

use Eseath\SxGeo\SxGeo;
use Illuminate\Support\Facades\Cookie;

class City
{
    public const CITY = 'Москва'; // город по умолчанию
    
    /**
     * Получение названия города по ip пользователя
     * Если город не определился, то возврашается город по умолчанию
     * Библиотека sxgeo
     * 
     * @param
     * @return string
     */
    public function get_city_from_ip(): string
    {
        $ip = request()->ip();

        if ($ip == '') {
            $ip == '127.0.0.1';
        }

        // Подключение файла с базой ip адресов 
        $sxGeo = new SxGeo('../storage/app/public/sxgeo/geoip.dat');

        // $fullInfo  = $sxGeo->getCityFull($ip);
        $briefInfo = $sxGeo->get($ip);

        $city = '';

        if ($briefInfo) {
            if ($briefInfo["country"]["iso"] == 'RU') {
                $city = $briefInfo["city"]["name_ru"];
            }
        }
        
        return $city ? $city : self::CITY;
    }

    /**
     * Получение название города из куки
     * 
     * @param
     * @return string название города
     */
    public function get_city_from_cookie(): string
    {
        // Получение куки через фасад Cookie метод get
        $cookie_city = json_decode(Cookie::get("city"), true);

        if ($cookie_city) {
            $city = \App\Models\City::find($cookie_city["id"]);
            return $city->city;
        }

        // По умолчанию пустая строка
        return "";
    }

    /**
     * Получение название области из куки
     * 
     * @param
     * @return string область
     */
    public function get_region_from_cookie(): string
    {
        // Получение куки через фасад Cookie метод get
        $cookie_city = json_decode(Cookie::get("city"), true);

        if ($cookie_city) {
            $city = \App\Models\City::find($cookie_city["id"]);
            return $city->region;
        }

        // По умолчанию пустая строка
        return "";
    }

    /**
     * Получение почтового индекса из куки
     * Возвращает целое число
     * 
     * @param
     * @return int
     */
    public function get_postcode_from_cookie(): int
    { 
        // Получение куки через фасад Cookie метод get
        $cookie_city = json_decode(Cookie::get('city'), true);

        if ($cookie_city) {
            $city = \App\Models\City::find($cookie_city["id"]);
            return $city->postal_code;
        }

        // По умолчанию 000000
        return 000000;
    }

}