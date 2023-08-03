<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RussianPost
{
    const FROM_POSTAL_CODE = '456320'; // Индекс отправителя
    // const OBJECT = '23030'; // Организация
    const OBJECT = '4020'; // Физлицо
    
    /**
     * Документация https://tariff.pochta.ru/post-calculator-api.pdf?99
     * Онлайн калькулятор https://tariff.pochta.ru/
     * Пример https://tariff.pochta.ru/#/106?object=4020&weight=1000&closed=1&sumoc=10000&date=20220617&time=1652
     * Онлайн калькулятор от заказчиков https://www.pochta.ru/parcel-new
     * method GET
     * format JSON
     * @param
     * @return string
     */
    public function tariff(): string
    { 
        $url = "https://tariff.pochta.ru/v2/calculate/tariff?";
        
        // Параметры: вес, город получателя, объявленная ценность (сумма всех товаров * 100)
        $params = [
            'object' => self::OBJECT,
            'from' => self::FROM_POSTAL_CODE,
            'to' => (new \App\Services\PostalCode)->get(),
            'weight' => (new \App\Services\ProductWeight)->weight_cart(),
            // 'pack' => '40', // Упаковка
            'closed'=> '1',
            'sumoc' => (new \App\Services\ProductSumm)->summ_cart() * 100 // Объявленная ценность. Сумма товара * 100
        ];

        $tariff = Http::get($url, $params);

        $tariff = $tariff->json();

        // return ($tariff["paymoneynds"]) / 100; // Итоговая сумма платы за дополнительные услуги с НДС в копейках

        //  return ($tariff["paynds"]) / 100; // Итоговая сумма платы с НДС в копейках

        // Округление копеек до рублей и возврат значения
        return array_key_exists("paynds", $tariff) ? round(($tariff["paynds"] / 100), 0) : "-";
    }
}