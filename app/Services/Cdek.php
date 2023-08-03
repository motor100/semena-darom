<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Cdek
{
    protected $token;
    // const
    
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
            "type" => 1, //.
            // "date" => date("c"),
            "currency" => 1, //.
            "tariff_code" => 136, //.
            "from_location" => [
                "postal_code" => "456300", //.
                "country_code" => "RU", //.
            ],
            "to_location" => [
                "postal_code" => $postal_code,
                // "postal_code" => 101000, // Москва
                'country_code' => "RU", //.
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

    /**
     * @params Illuminate\Database\Eloquent\Model
     * @return array
     */
    public function create_order($order)
    {
        // Получаю токен
        $token = $this->get_token();
        
        // Тестовая ссылка
        // $url = "https://api.edu.cdek.ru/v2/orders";

        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/orders";

        // Формирую параметры заказа
        $order_params = [
            "type" =>	1, // Тип заказа 1 - интернет магазин
            "number" => $order->id . "-" . mt_rand(), // уникальный номер заказа. 4 - номер заказа + случайное число
            // "tariff_code" => 136, // код тарифа
            "tariff_code" => 139,
            "from_location" => [
                "code" => "7", // Миасс
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
            "to_location" => [],
            "packages" => [
                "number" => $order->id, // Номер упаковки. Можно вставить номер заказа
                "weight" => (new \App\Services\ProductWeight)->weight_order($order), // общий вес
                "items" => [],
            ],
            "recipient" => [],
            "sender" => [
                "name" => "ИП Варнавин А.С."
            ],
            "print" => "waybill" // Формирование квитанции к заказу
            // 1 способ. Создать квитанцию вместе с заказом. Как сейчас
            // 2 способ. Создать квитанцию отдельным методом. Документация https://api-docs.cdek.ru/36967276.html
        ];

        // Формирую город получателя
        $cdek_city = $this->get_offices($order->city_id);
        $order_params["to_location"] = $cdek_city[0];
        $order_params["to_location"]["address"] = $order->address;

        // Формирую товары в заказе
        foreach($order->products as $product) {
            $item = [
                "ware_key" => $product->code, // Артикул. В данном случае уникальный штрихкод
                "payment" => [
                    "value" => 0 // предоплата
                ],
                "name" => $product->title,
                "amount" => $product->pivot->quantity,
                "cost" => $product->promo_price ? $product->promo_price : $product->retail_price, // цена
                "weight" => $product->weight, // вес
            ];

            $order_params["packages"]["items"][] = $item;
        }

        // Формирую получателя
        $order_params["recipient"]["name"] = $order->first_name . " " . $order->last_name;
        $order_params["recipient"]["phones"]["number"] = "+" . $order->phone;

        // Запрос API СДЕК
        $response = Http::withToken($token)->post($url, $order_params);
        
        $response_array = $response->json();

        return $response_array;
    }

    public function create_document($order_uuid)
    {
        // $token = $this->token ? $this->token : $this->get_token();
        // Получаю токен
        $token = $this->get_token();

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

    public function get_waybill($id)
    {
        $token = $this->token ? $this->token : $this->get_token();
        
        /*
        // Тестовая ссылка
        // $url = "https://api.edu.cdek.ru/v2/print/orders/" . $document_uuid;

        // Рабочая ссылка
        // $url = "https://api.cdek.ru/v2/print/orders/" . $document_uuid;
        $url = "https://api.cdek.ru/v2/print/orders/" . $document_uuid;
        
        $response = Http::withToken($token)->get($url);

        $response_array = $response->json();
        
        return $response_array;
        */

        // Получаю модель CdekOrder по номеру заказа
        $cdek_order = \App\Models\CdekOrder::where('order_id', $id)->first();

        // url для получения квитанции pdf
        $url_pdf = 'https://api.cdek.ru/v2/print/orders/' . $cdek_order->waybill_uuid . '.pdf';

        // Запрос для получения квитанции pdf
        $response_pdf = \Illuminate\Support\Facades\Http::withToken($token)->get($url_pdf);

        // Имя файла
        $filename = $cdek_order->waybill_uuid . '.pdf';

        // Сохранение файла
        \Illuminate\Support\Facades\Storage::put('/public/print-forms/' . $filename, $response_pdf);

        return $filename;
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

    /**
     * Список населенных пунктов
     * Документация https://api-docs.cdek.ru/33829437.html
     */
    public function get_offices($city_id)
    {
        $token = $this->token ? $this->token : $this->get_token();

        $city = \App\Models\City::find($city_id);
        
        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/location/cities";

        $params = [
            "city" => $city->city,
            "postal_code" => $city->postal_code
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

        $this->token = $response_token->json("access_token");

        return $response_token->json("access_token");
    }
}