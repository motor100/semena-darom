<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    /**
     * Документация https://api-docs.cdek.ru/63345430.html
     * @param
     * @return string
     */
    public function sdek()
    {
        // Почтовый индекс выбранного города
        $postal_code = (new \App\Services\PostalCode())->get();

        // Вес всех товаров в корзине
        $weight = (new \App\Services\ProductWeight())->weight_cart();
        
        // Тариф на доставку
        $tariff = (new \App\Services\Cdek())->tariff($weight, $postal_code);
        
        return $tariff;
    }

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
    /*
    * В отдельный класс
    */
    public function russian_post(Request $request)
    {
        // Параметры: вес, город получатель, объявленная ценность (сумма всех товаров * 100)
        $params = array(
            // 'object' => '23030', // организация
            'object' => '4020', // физлицо
            'from' => '456320',
            'to' => $this->get_postal_code(),
            'weight' => $this->get_weight(),
            // 'pack' => '40', // Упаковка
            'closed'=> '1',
            'sumoc'=> '50000', // Объявленная ценность. Сумма товара * 100
        );

        $url = "https://tariff.pochta.ru/v2/calculate/tariff?";

        $tariff = Http::get($url, $params);

        $tariff = $tariff->json();

        // return ($tariff["paymoneynds"]) / 100; // Итоговая сумма платы за дополнительные услуги с НДС в копейках

        // return ($tariff["paynds"]) / 100; // Итоговая сумма платы с НДС в копейках

        // Округление
        $summ = round(($tariff["paynds"] / 100), 0);

        return $summ;
    }
}
