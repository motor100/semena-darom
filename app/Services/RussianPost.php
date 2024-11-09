<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RussianPost
{
    const FROM_POSTAL_CODE = '456320'; // Индекс отправителя
    // const OBJECT = '23030'; // Организация
    const OBJECT = '4020'; // Физлицо

    /**
     * @var string Рабочая ссылка для получения токена
     */
    public const WORK_URL_TOKEN = "https://otpravka-api.pochta.ru";
    
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

    public function test()
    {
        $url_token = "https://otpravka-api.pochta.ru";
        $path = "/1.0/user/backlog";
        $url = $url_token . $path;

        $login_password = base64_encode('crm-74ss@yandex.ru:7415086375');

        $params = [
        [
            "address-type-to" => "DEFAULT",
            "given-name" => "Иван",
            "house-to" => "37",
            "index-to" => 117105,
            "mail-category" => "ORDINARY",
            "mail-direct" => 643,
            "mail-type" => "POSTAL_PARCEL",
            "mass" => 1000,
            "middle-name" => "Иванович",
            "order-num" => "001",
            "place-to" => "г Москва",
            "postoffice-code" => "101000",
            "region-to" => "г Москва",
            "street-to" => "ш Варшавское",
            "surname" => "Иванов",
            "tel-address" => 79459562067,
            "transport-type" => "SURFACE",
            "dimension" => [
                "height" => 3,
                "length" => 9,
                "width" => 73
            ],
            "fragile" => "true"
        ],
	    [
            # По данному объекту ожидается ошибка при обработке: "code" : "ILLEGAL_MASS_EXCESS"
            # т.к. масса больше установленного ограничения

            "address-type-to" => "DEFAULT",
            "given-name" => "Сергей",
            "house-to" => "13",
            "index-to" => 630084,
            "mail-category" => "ORDINARY",
            "mail-direct" => 643,
            "mail-type" => "POSTAL_PARCEL",
            "mass" => 2000,
            "middle-name" => "Владимирович",
            "order-num" => "002",
            "place-to" => "г Новосибирск",
            "postoffice-code" => "101000",
            "region-to" => "обл Новосибирская",
            "room-to" => "99",
            "street-to" => "проезд Газовый",
            "surname" => "Сидоров",
            "tel-address" => 79458712076,
            "transport-type" => "SURFACE"
        ]
        ];

        $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json;charset=UTF-8',
                        'Authorization' => 'AccessToken ' . config('russianpost.application_token'),
                        'X-User-Authorization' => 'Basic ' . $login_password,
                         ])
                    ->put($url, $params);
  
        dd($response->json());
    }

    /**
     * Авторизация и получение токена API Почта России
     * Документация https://otpravka.pochta.ru/specification#/authorization-token
     * 
     * @param
     * @return mixed
     */
    public function get_token(): mixed
    {
        // Рабочая ссылка
        $url_token = self::WORK_URL_TOKEN;

        $params_token = [
            'Authorization' => 'AccessToken ' . config('russianpost.application_token'),
        ];

        // Метод asForm() устанавливает Content-type: application/x-www-form-urlencoded
        // Без него по умолчанию передается Content-type: application/json
        $response_token = Http::withHeaders([
                                // 'Content-Type' => 'application/json',
	                            'Accept' => 'application/json;charset=UTF-8',
	                            'Authorization' => 'AccessToken ' . config('russianpost.application_token'),
	                            'X-User-Authorization' => 'Basic ' . config('russianpost.user_key')
                                ])
                            // ->asForm()
                            ->post($url_token);

        // Если статус ответа 200, то возвращаю токен
        dd($response_token);
        // if ($response_token->status() == 200) {
        //     $this->token = $response_token->json("access_token");

        //     return $response_token->json("access_token");
        // }

        return false;
    }
}