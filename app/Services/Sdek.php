<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Sdek
{
    protected $token;
    
    /**
     * Документация https://api-docs.cdek.ru/63345430.html
     */

    public function tariff($weight, $postal_code)
    { 
        $token = $this->get_token();
        
        // Запрос на расчет
        // Тестовая ссылка
        // $url_tariff = 'https://api.edu.cdek.ru/v2/calculator/tariff';

        // Рабочая ссылка
        $url_tariff = "https://api.cdek.ru/v2/calculator/tariff";

        $params_tariff = [
            "type" => 1,
            // "date" => date("c"),
            "currency" => 1,
            "tariff_code" => 136,
            "from_location" => [
                "postal_code" => "456300",
                "country_code" => "RU",
            ],
            "to_location" => [
                "postal_code" => $postal_code,
                // "postal_code" => 101000, // Москва
                'country_code' => "RU",
            ],
            /*
            // Услуга по упаковке
            "services" => array(
                array(
                    "code" => "PACKAGE_1",
                    // "parameter" => "1"
                )
            ),
            */
            "packages" => [
                [
                    "height" => 20, // сантиметр
                    "length" => 20, // сантиметр
                    "weight" => $weight, // грамм
                    "weight" => 500,
                    "width" => 20 // сантиметр
                ]
            ]
        ];

        // Метод withToken(token) передает Bearer токен в заголовке
        $response_tariff = Http::withToken($token)->post($url_tariff, $params_tariff);

        $tariff = $response_tariff->json();

        // Ошибки
        // if (array_key_exists("errors", $tariff)) {
        //     return $tariff["errors"];
        // }

        // Сумма
        // $tariff["delivery_sum"]

        // Срок доставки
        // return $tariff["period_min"] . "-" . $tariff["period_max"] . " дней";

        return array_key_exists("delivery_sum", $tariff) ? $tariff["delivery_sum"] : "-";
    }

    public function create_order()
    {
        $token = $this->token ? $this->token : $this->get_token();
        
        // Тестовая ссылка
        // $url = "https://api.edu.cdek.ru/v2/orders";

        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/orders";

        $params = [
            "type" =>	1, // Тип заказа 1 - интернет магазин
            "number" => 4 . "-" . mt_rand(), // уникальный номер заказа. 4 - номер заказа + случайное число
            // "tariff_code" => 136, // код тарифа
            "tariff_code" => 139,
            "from_location" => [
                "code" => "7",
                "fias_guid" => "",
                "postal_code" => "456300",
                "longitude" => "",
                "latitude" => "",
                "country_code" => "RU",
                "region" => "Челябинская область",
                "sub_region" => "",
                "city" => "Миасс",
                "kladr_code" => "",
                "address" => ""
            ],
            "to_location" => [
                "code" => "270",
                "fias_guid" => "",
                "postal_code" => "",
                "longitude" => "",
                "latitude" => "",
                "country_code" => "",
                "region" => "",
                "sub_region" => "",
                "city" => "Новосибирск",
                "kladr_code" => "",
                "address" => "ул. Блюхера, 32"
            ],
            "packages" => [
                "number" => 4, // Номер упаковки. Можно вставить номер заказа
                "weight" => 200, // общий вес
                "items" => [ // товары
                    0 => [
                        "ware_key" => "00055", // артикул
                        "payment" => [
                            "value" => 0 // предоплата
                        ],
                        "name" => "Томат", // название
                        "amount" => 2, // количество
                        "cost" => 12, // цена
                        "weight" => 100, // вес
                    ],
                    1 => [
                        "ware_key" => "00056", // артикул
                        "payment" => [
                            "value" => 0 // предоплата
                        ],
                        "name" => "Огурец",
                        "amount" => 1,
                        "cost" => 120,
                        "weight" => 120,
                    ]
                ]
            ],
            "recipient" => [
                "name" => "Иванов Иван",
		        "phones" => [
		            "number" => "+79134637228"
                ],
            ],
            "sender" => [
                "name" => "Петров Петр"
            ],
            "print" => "waybill"
        ];

        $response = Http::withToken($token)->post($url, $params);
        
        // dd($response->json());
        $response_array = $response->json();

        // return $response_array["related_entities"][0]["uuid"];
        // return $response_array["entity"]["uuid"];
        return $response_array;
    }

    public function create_document($order_uuid)
    {
        $token = $this->token ? $this->token : $this->get_token();

        // Тестовая ссылка
        // $url = "https://api.edu.cdek.ru/v2/print/orders";

        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/print/orders";

        $params = [
            "orders" => [
                "order_uuid" => $order_uuid,
            ],
            "copy_count" => 2,
        ];

        $response = Http::withToken($token)->post($url, $params);
        
        // dd($response_order->json());
        $response_array = $response->json();
        
        return $response_array;
        // return $response_array;
    }

    public function download_document($document_uuid)
    {
        $token = $this->token ? $this->token : $this->get_token();
        
        // Тестовая ссылка
        // $url = "https://api.edu.cdek.ru/v2/print/orders/" . $document_uuid;

        // Рабочая ссылка
        // $url = "https://api.cdek.ru/v2/print/orders/" . $document_uuid;
        $url = "https://api.cdek.ru/v2/print/orders/" . $document_uuid;
        
        $response = Http::withToken($token)->get($url);

        $response_array = $response->json();
        
        return $response_array;
    }

    public function order_info($order_uuid)
    {
        $token = $this->token ? $this->token : $this->get_token();
        
        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/orders/" . $order_uuid;
        
        $response = Http::withToken($token)->get($url);

        $response_array = $response->json();

        return $response_array;
    }

    public function get_offices()
    {
        $token = $this->token ? $this->token : $this->get_token();
        
        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/location/cities";

        $params = [
            "city" => "Миасс",
        ];
        
        $response = Http::withToken($token)->get($url, $params);

        $response_array = $response->json();
        
        return $response_array;
    }


    public function get_token()
    {
        // Получаю токен
        // Тестовая ссылка
        // $url_token = "https://api.edu.cdek.ru/v2/oauth/token";

        // Рабочая ссылка
        $url_token = "https://api.cdek.ru/v2/oauth/token";

        $params_token = [
            'grant_type' =>	'client_credentials',
            'client_id'	=> config('sdek.client_id'),
            'client_secret'	=> config('sdek.client_secret')
        ];

        // Метод asForm() устанавливает Content-type: application/x-www-form-urlencoded
        // Без него по умолчанию передается Content-type: application/json
        $response_token = Http::asForm()->post($url_token, $params_token);

        // return $response_token->json("access_token");

        $this->token = $response_token->json("access_token");

        return $response_token->json("access_token");
    }
}