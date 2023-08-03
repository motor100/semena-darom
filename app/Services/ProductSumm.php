<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use App\Models\Product;

class ProductSumm
{
    /**
     * Получение суммы всех товаров в корзине (общая стоимость заказа)
     * @param
     * @return int
     */
    public function summ_cart(): int
    { 
        // Получение куки через фасад Cookie метод get
        $cookie_cart = json_decode(Cookie::get('cart'), true);

        $summ = 0;

        if ($cookie_cart) {

            $keys = array_keys($cookie_cart);

            // Получение моделей товаров
            $products = Product::whereIn('id', $keys)->get();

            foreach($products as $product) {
                $product->quantity = $cookie_cart[$product->id];
                $product->prc = $product->promo_price ? $product->promo_price : $product->retail_price;
                $product->summ = (int) $product->quantity * (int) $product->prc;
                $summ += $product->summ;
            }
        }

        return $summ;
    }
}