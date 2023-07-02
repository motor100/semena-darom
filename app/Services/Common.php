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
        
        if ($request->session()->has('cart')) {

            $cart_items = $request->session()->get('cart');

            $keys = array_keys($cart_items);

            // Получение моделей товаров
            $products = \App\Models\Product::whereIn('id', $keys)->get();
            
            // Предзаказ
            // foreach ($products as $product) {
            //     if ($product->stock > 0) {
            //         $products[] = $product;
            //     }
            // }
            
            // Количество каждого товара
            foreach ($products as $product) {
                $product->quantity = $cart_items[$product->id];
                // $product->count = $product;
            }
        }

        return $products;
    }
}