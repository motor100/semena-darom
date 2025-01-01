<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RussianPost
{
    const FROM_POSTAL_CODE = '456320'; // Индекс отправителя

    const OBJECT = '4020'; // 4020 Физлицо или 23030 Организация

    const TARIFF_URL = "https://tariff.pochta.ru/v2/calculate/tariff";

    const CREATE_ORDER_URL = "https://otpravka-api.pochta.ru"; // Адрес доступа к API для создания заказа
    
    /**
     * Расчет стоимости доставки (тариф)
     * Документация https://tariff.pochta.ru/post-calculator-api.pdf?99
     * Онлайн калькулятор https://tariff.pochta.ru/
     * Пример https://tariff.pochta.ru/#/106?object=4020&weight=1000&closed=1&sumoc=10000&date=20220617&time=1652
     * Онлайн калькулятор от заказчиков https://www.pochta.ru/parcel-new
     * 
     * @param
     * @return string
     */
    public function tariff(): string
    { 
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

        $tariff = Http::get(self::TARIFF_URL, $params); // method GET format JSON

        $tariff = $tariff->json();

        // return ($tariff["paymoneynds"]) / 100; // Итоговая сумма платы за дополнительные услуги с НДС в копейках

        //  return ($tariff["paynds"]) / 100; // Итоговая сумма платы с НДС в копейках

        // Если есть "paynds", то округляю копейки до рублей. Иначе "-".
        return array_key_exists("paynds", $tariff) ? round(($tariff["paynds"] / 100), 0) : "-";
    }

    /**
     * Создание заказа
     * Документация https://otpravka.pochta.ru/specification#/orders-creating_order
     * 
     * @param Illuminate\Database\Eloquent\Model Order
     * @return
     */
    public function create_order($order)
    {
        // Формирую url
        $path = "/1.0/user/backlog";
        $url = self::CREATE_ORDER_URL . $path;

        // Кодирую логин и пароль russianpost_login
        // $login_password_string = config('russianpost.login') . ":" . config('russianpost.password');

        // $login_password = base64_encode($login_password_string);
        $login_password = base64_encode('crm-74ss@yandex.ru:7415086375');

        $params = [
            [
                "address-type-to" => "DEFAULT",
                "given-name" => $order->first_name, // имя получателя
                "house-to" => "13", // дом получателя
                "index-to" => $order->postcode, // индекс получателя
                "mail-category" => "ORDINARY",
                "mail-direct" => 643,
                "mail-type" => "PARCEL_CLASS_1", // посылка первого класса
                "mass" => 2000,
                "middle-name" => "",
                "order-num" => $order->id, // номер заказа
                "place-to" => "г Новосибирск",
                "postoffice-code" => self::FROM_POSTAL_CODE, // индекс отправителя
                "region-to" => "обл Новосибирская",
                "room-to" => "99",
                "street-to" => "проезд Газовый",
                "surname" => $order->last_name,
                "tel-address" => $order->phone,
                "transport-type" => "SURFACE"
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json;charset=UTF-8',
            'Authorization' => 'AccessToken ' . config('russianpost.access_token'),
            'X-User-Authorization' => 'Basic ' . $login_password,
        ];

        $response = Http::withHeaders($headers)->put($url, $params);
  
        dd($response->json());
    }
}