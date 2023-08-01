<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    public function sdek()
    {
        // Почтовый индекс выбранного города
        $postal_code = (new \App\Services\PostalCode())->get();

        // Вес всех товаров в корзине
        $weight = (new \App\Services\ProductWeight())->get();
        
        // Тариф на доставку
        $tariff = (new \App\Services\Sdek())->tariff($weight, $postal_code);
        
        return $tariff;
    }

    public function create_order111()
    {
        $token = (new \App\Services\Sdek())->get_token();
        
        // Тестовая ссылка
        $url_order = "https://api.edu.cdek.ru/v2/orders";

        // Рабочая ссылка
        // $url_order = "https://api.cdek.ru/v2/orders";

        $params_order = [
            "type" =>	1,
            "number" =>	4,
            "tariff_code" => 136,
            "from_location" => [
                "postal_code" => "456300",
                "country_code" => "RU",
            ],
            "to_location" => [
                "postal_code" => 101000, // Москва
                "country_code" => "RU",
                "region" => "Московская область",
                "city" => "Москва",
                "address" => "пр. Ленинградский, д.4"
            ],
            "packages" => [
                "number" => 4, // Москва
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
        ];

        $response_order = Http::withToken($token)->post($url_order, $params_order);
        
        // dd($response_order->json());
        $response_array = $response_order->json();

        return $response_array["entity"]["uuid"];
    }

    public function create_order()
    {
        $sdek = new \App\Services\Sdek();

        $order = $sdek->create_order();

        // $document = $sdek->create_document($order["entity"]["uuid"]);

        // $download = $sdek->download_document($document["entity"]["uuid"]);
        // $download = $sdek->download_document($order["related_entities"][0]["uuid"]);
        // 72753034-7ade-40ff-ac4d-e33aaf5fbdc2
        // $offices = $sdek->get_offices();

        // $order_info = $sdek->order_info($order["entity"]["uuid"]);
        
        // dd($order_uuid, $document_uuid, $download, $order_info);
        return $order["related_entities"][0]["uuid"];
    }

    public function download_document()
    {
        $document_uuid = "72753034-4a2b-4d42-af14-c2fa9904b2e9";

        $sdek = new \App\Services\Sdek();

        $download = $sdek->download_document($document_uuid);

        dd($download);
    }

    /*
    * Документация https://tariff.pochta.ru/post-calculator-api.pdf?99
    * Онлайн калькулятор https://tariff.pochta.ru/
    * Пример https://tariff.pochta.ru/#/106?object=4020&weight=1000&closed=1&sumoc=10000&date=20220617&time=1652
    * Онлайн калькулятор от заказчиков https://www.pochta.ru/parcel-new
    * method GET
    * format JSON
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

    public function get_postal_code()
    {
        // Город
        // Получение куки через фасад Cookie метод get
        $city = json_decode(\Illuminate\Support\Facades\Cookie::get('city'), true);

        if ($city) {
            $postal_code = \App\Models\City::where("id", $city["id"])->first()->postal_code;
        } else {
            $postal_code = 101000;
        }

        return $postal_code;
    }

    public function get_weight()
    {
        // Получение куки через фасад Cookie метод get
        $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

        $weight = 0;

        if ($cart) {

            $keys = array_keys($cart);

            // Получение моделей товаров
            $products = \App\Models\Product::whereIn('id', $keys)->get();

            foreach($products as $product) {
                $product->quantity = $cart[$product->id];
                $product->weight = (int) $product->quantity * (int) $product->weight;
                $weight += $product->weight;
            }
        }

        return $weight;
    }
}
