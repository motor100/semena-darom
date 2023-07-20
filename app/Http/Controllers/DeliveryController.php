<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeliveryController extends Controller
{
    /**
     * Документация https://api-docs.cdek.ru/63345430.html
     */
    public function sdek(Request $request)
    {
        return 350;
        // Получаю токен
        // Тестовая ссылка
        $url_token = "https://api.edu.cdek.ru/v2/oauth/token";

        // Рабочая ссылка
        // $url_token = "https://api.cdek.ru/v2/oauth/token";

        $params_token = [
            'grant_type' =>	'client_credentials',
            // тестовая учетная запись
            'client_id'	=> config('sdek.client_id'),
            'client_secret'	=> config('sdek.client_secret')
        ];

        // Метод asForm() устанавливает Content-type: application/x-www-form-urlencoded
        // Без него по умолчанию передается Content-type: application/json
        $response_token = Http::asForm()->post($url_token, $params_token);

        $token = $response_token->json("access_token");

        // Запрос на расчет
        // Тестовая ссылка
        $url_tariff = 'https://api.edu.cdek.ru/v2/calculator/tariff';

        // Рабочая ссылка
        // $url_tariff = "https://api.cdek.ru/v2/calculator/tariff";

        $params_tariff = [
            "type" => 1,
            // "date" => date("c"),
            "currency" => 1,
            "tariff_code" => 136,
            "from_location" => [
                "postal_code" => "456300",
                "country_code" => 'RU',
            ],
            "to_location" => [
                "postal_code" => $this->get_postal_code(),
                'country_code' => 'RU',
            ],
            /*
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
                    "weight" => $this->get_weight(), // грамм
                    "width" => 20 // сантиметр
                ]
            ]
        ];

        // Метод withToken(token) передает Bearer токен в заголовке
        $response_tariff = Http::withToken($token)->post($url_tariff, $params_tariff);

        $tariff = $response_tariff->json();

        if (array_key_exists("errors", $tariff)) {
            return $tariff["errors"];
        }

        // Сумма
        // $tariff["delivery_sum"]

        // Срок доставки
        // return $tariff["period_min"] . "-" . $tariff["period_max"] . " дней";

        return $tariff["delivery_sum"];
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
