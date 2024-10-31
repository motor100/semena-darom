<?php

namespace App\Services;

use Eseath\SxGeo\SxGeo;

class City
{
    public const CITY = 'Москва'; // город по умолчанию
    
    /**
     * Название города по ip
     * 
     * @param
     * @return string
     */
    public function get_city_name(): string
    {
        $ip = request()->ip();

        if ($ip == '') {
            $ip == '127.0.0.1';
        }

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

}