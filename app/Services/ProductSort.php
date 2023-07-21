<?php

namespace App\Services;

class ProductSort
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function get()
    {
        $products = $this->model->products;

        // Добавляю номер заказа, количество и сумму к каждому товару
        foreach($products as $product) {
            $product->order_id = $this->model->id;

            // Расчет суммы одного товара
            if ($product->promo_price) {
                // $value->summ = $value->promo_price * $value->quantity;
                $product->summ = $product->promo_price * $product->pivot->quantity;
            } else {
                // $value->summ = $value->retail_price * $value->quantity;
                $product->summ = $product->retail_price * $product->pivot->quantity;
            }

            $product->quantity = $product->pivot->quantity;
        }

        // Сортировка коллекции
        // Категория Семена, все кроме категории 2. Сортировка по значению в столбце position
        $cat1 = $products->where('category_id', '<>', '2')->sortBy('position');
        // Категория Агрохимия, категории 2. Сортировка по значению в столбце position
        $cat2 = $products->where('category_id', '2')->sortBy('position');

        // Объединение в одну коллекцию
        // Сначала Семена, потом Агрохимия
        // К коллекции cat1 (Семена) присоединяю коллекцию cat2 (Агрохимия)
        $products = $cat1->merge($cat2);
        
        return $products;
    }
}