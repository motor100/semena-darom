<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use App\Models\Product;

class ProductWeight
{
    /**
     * Получение веса всех товаров в корзине в граммах
     * Получение товаров из куки
     * На странице оформление заказа расчет тарифа доставки 
     * 
     * @param
     * @return int
     */
    public function weight_cart(): int
    { 
        // Получение куки через фасад Cookie метод get
        $cookie_cart = json_decode(Cookie::get('cart'), true);

        $weight = 0;

        if ($cookie_cart) {

            $keys = array_keys($cookie_cart);

            // Получение моделей товаров
            $products = Product::whereIn('id', $keys)->get();

            foreach($products as $product) {
                $product->quantity = $cookie_cart[$product->id];
                $product->weight = (int) $product->quantity * (int) $product->weight;
                $weight += $product->weight;
            }
        }

        return $weight;
    }

    /**
     * Получение веса всех товаров в заказе
     * Получение товаров из заказа
     * 
     * @param Illuminate\Database\Eloquent\Model Order
     * @return int
     */
    public function weight_order($order): int
    {
        $products = $order->products;

        $weight = 0;

        foreach($products as $product) {
            $product->total_weight = (int) $product->pivot->quantity * (int) $product->weight;
            $weight += $product->total_weight;
        }

        return $weight;
    }
}