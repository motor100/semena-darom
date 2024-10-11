<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    /**
     * СДЕК расчет тарифа на доставку
     * @param
     * @return string
     */
    public function sdek(): string
    {
        return (new \App\Services\Cdek())->tariff();
    }

    /**
     * Почта России расчет тарифа на доставку
     * @param
     * @return string
     */
    public function russian_post(): string
    {
        return (new \App\Services\RussianPost)->tariff();
    }
}
