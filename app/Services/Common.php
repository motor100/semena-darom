<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class Common {

    /**
     * Pagination with limit
     * @param Illuminate\Database\Eloquent\Collection
     * @param integer
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public static function custom_paginator($collection, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($currentPage == 1) {
            $start = 0;
        }
        else {
            $start = ($currentPage - 1) * $perPage;
        }

        $currentPageCollection = $collection->slice($start, $perPage)->all();

        $paginatedTop100 = new LengthAwarePaginator($currentPageCollection, count($collection), $perPage);

        return $paginatedTop100->setPath(LengthAwarePaginator::resolveCurrentPath());
    }

    /**
     * Получение названия категории
     * Функция возвращает название категории по ее slug из запроса
     * @param Illuminate\Http\Request
     * @return string
     */
    public static function get_category_title(Request $request): string
    {
        if ($request->has('category')) {
            $category = \App\Models\Category::where('slug', $request->category)->first();
            return $category ? $category->title : "";
        } else {
            return "";
        }

    }

    /**
     * Получение товаров в корзине
     * @param Illuminate\Http\Request
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function get_products_in_cart(Request $request)
    {
        $products = collect();
        
        if ($request->hasCookie('cart')) {

            // Получение куки через фасад Cookie метод get
            $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

            $keys = array_keys($cart);

            // Получение моделей товаров
            $products = \App\Models\Product::whereIn('id', $keys)->get();
            
            // Предзаказ
            // foreach ($products as $product) {
            //     if ($product->stock > 0) {
            //         $products[] = $product;
            //     }
            // }
            
            // Добавляю количество к каждому товару
            foreach ($products as $product) {
                $product->quantity = $cart[$product->id];
            }
        }

        return $products;
    }

    /**
     * Число 79999999999 в телефон в формате +7 (999) 999 99 99
     * @param number
     * @return string
     */
    public static function int_to_phone($number)
    {
        $phone = strval($number);
        $phone = '+'.substr($phone, 0, 1).' '.'('.substr($phone, 1, 3).')'.' '.substr($phone, 4, 3).' '.substr($phone, 7, 2).' '.substr($phone, 9, 2);

        return $phone;
    }

    /**
    * Телефон в формате +7 (999) 999 99 99 в число
    * @param string
    * @return int
    */
    public static function phone_to_int($phone)
    {
        $symbols = ["+", " ", "(", ")", "-"];
        $phone = str_replace($symbols, '', $phone);

        return (int) $phone;
    }


}