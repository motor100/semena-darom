<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use App\Models\Product;

class ProductWeight
{
    public function weight_cart()
    { 
        // Получение веса всех товаров в корзине
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

    public function weight_order($order)
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