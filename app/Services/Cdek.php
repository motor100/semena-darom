<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Cdek
{
    protected $token;
    
    const TYPE = 1; // Тип заказа 1 - интернет магазин
    // const TARIFF_CODE = 136 // Посылка склад-склад
    const TARIFF_CODE = 139; // Посылка дверь-дверь
    const CURRENCY = 1; // Валюта Российский рубль
    const FROM_POSTAL_CODE = "456320"; // Индекс отправителя
    const COUNTRY_CODE = "RU"; // Страна
    const FROM_REGION = "Челябинская область"; // Регион отправителя
    const FROM_CITY = "Миасс"; // Город отправителя
    const FROM_CODE = "7"; // Код города СДЕК Миасс
    const SENDER_NAME = "ИП Варнавин А.С."; // Имя отправителя

    /**
     * @var string Test client id or Account
     */
    public const TEST_CLIENT_ID = "wqGwiQx0gg8mLtiEKsUinjVSICCjtTEP1";

    /**
     * @var string Test client secret or Secure password
     */
    public const TEST_CLIENT_SECRET = "RmAmgvSgSl1yirlz9QupbzOJVqhCxcP5";

    /**
     * @var string Тестовая ссылка для получения токена
     */
    public const TEST_URL_TOKEN = "https://api.edu.cdek.ru/v2/oauth/token";

    /**
     * @var string Рабочая ссылка для получения токена
     */
    public const WORK_URL_TOKEN = "https://api.cdek.ru/v2/oauth/token";
    
    /**
     * Документация https://api-docs.cdek.ru/63345430.html
     * @param
     * @return string
     */
    public function tariff(): string
    { 
        $token = $this->get_token();

        // Если не пришел токен, то возвращаю "-"
        if (!$token) {
            return "-";
        }
        
        // Запрос на расчет
        // Тестовая ссылка
        // $url_tariff = 'https://api.edu.cdek.ru/v2/calculator/tariff';

        // Рабочая ссылка
        $url_tariff = "https://api.cdek.ru/v2/calculator/tariff";

        $params_tariff = [
            "type" => self::TYPE,
            "currency" => self::CURRENCY,
            "tariff_code" => self::TARIFF_CODE,
            "from_location" => [
                "postal_code" => self::FROM_POSTAL_CODE,
                "country_code" => self::COUNTRY_CODE,
            ],
            "to_location" => [
                "postal_code" => (new \App\Services\PostalCode)->get(),
                "country_code" => self::COUNTRY_CODE,
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
                    "weight" => (new \App\Services\ProductWeight())->weight_cart(), // Вес всех товаров в корзине в граммах
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
     * Регистрация заказа
     * Документация https://api-docs.cdek.ru/29923926.html
     * @param Illuminate\Database\Eloquent\Model Order
     * @return array
     */
    public function create_order($order): array
    {
        // Получаю токен
        $token = $this->get_token();
        
        // Тестовая ссылка
        // $url = "https://api.edu.cdek.ru/v2/orders";

        // Рабочая ссылка
        $url = "https://api.cdek.ru/v2/orders";

        // Формирую параметры заказа
        $order_params = [
            "type" => self::TYPE,
            "number" => $order->id . "-" . mt_rand(), // уникальный номер заказа. Номер заказа + случайное число
            "tariff_code" => self::TARIFF_CODE,
            "from_location" => [
                "code" => self::FROM_CODE,
                "fias_guid" => "",
                "postal_code" => self::FROM_POSTAL_CODE,
                "longitude" => "",
                "latitude" => "",
                "country_code" => self::COUNTRY_CODE,
                "region" => self::FROM_REGION,
                "sub_region" => "",
                "city" => self::FROM_CITY,
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
                "name" => self::SENDER_NAME
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

    /**
     * Получение квитанции к заказу
     * Документация https://api-docs.cdek.ru/36967287.html
     * @param string номер заказа
     * @return string
     */
    public function get_waybill($id): string
    {
        $token = $this->token ? $this->token : $this->get_token();

        // Получаю модель CdekOrder по номеру заказа
        $cdek_order = \App\Models\CdekOrder::where('order_id', $id)->first();

        // URL для получения квитанции pdf
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
     * @param string id города из таблицы cities
     * @return array
     */
    public function get_offices($city_id): array
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

    /**
     * Авторизация и получение токена API СДЕК
     * Документация https://api-docs.cdek.ru/29923918.html
     * @param
     * @return mixed
     */
    public function get_token(): mixed
    {
        // Тестовая ссылка
        // $url_token = self::TEST_URL_TOKEN;

        // Рабочая ссылка
        $url_token = self::WORK_URL_TOKEN;

        $params_token = [
            'grant_type' =>	'client_credentials',

            // Тестовые client_id и client_secret
            // 'client_id'	=> self::TEST_CLIENT_ID,
            // 'client_secret'	=> self::TEST_CLIENT_SECRET,

            // Рабочие client_id и client_secret
            'client_id'	=> config('sdek.client_id'),
            'client_secret'	=> config('sdek.client_secret'),
        ];

        // Метод asForm() устанавливает Content-type: application/x-www-form-urlencoded
        // Без него по умолчанию передается Content-type: application/json
        $response_token = Http::asForm()->post($url_token, $params_token);

        // Если статус ответа 200, то возвращаю токен
        if ($response_token->status() == 200) {
            $this->token = $response_token->json("access_token");

            return $response_token->json("access_token");
        }

        return false;
    }
}