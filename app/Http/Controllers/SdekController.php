<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SdekController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $weight = $request->input("weight");
        $weight = 3000;

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
            "tariff_code" => 137,
            "from_location" => [
                "code" => 7, // Миасс
                // "code" => 270,
            ],
            "to_location" => [
                "code" => 2789 // Москва Рублево
                // "code" => 44 // Москва Рублево
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
                    "weight" => $weight, // грамм
                    "width" => 20 // сантиметр
                ]
            ]
        ];

        // Метод withToken(token) передает Bearer токен в заголовке
        $response_tariff = Http::withToken($token)->post($url_tariff, $params_tariff);

        $tariff = $response_tariff->json();

        dd($tariff);

        // Сумма
        // $tariff["delivery_sum"]

        // Срок доставки
        // $tariff["period_min"] . "-" . $tariff["period_max"] . " дней";
        
        return false;

    }
}
