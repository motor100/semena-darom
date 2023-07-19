<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class AdminController extends Controller
{
    public function home()
    {
        return view('dashboard.home');
    }

    public function profile()
    {
        return;
    }

    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::whereNull('publicated_at')
                                        ->orderBy('created_at', 'desc')
                                        // ->limit(20)
                                        ->get();

        return view('dashboard.testimonials', compact('testimonials'));
    }

    public function orders()
    {
        $orders = \App\Models\Order::orderBy('id', 'desc')
                                    ->limit(50)
                                    ->get();
        
        $orders = \App\Services\Common::custom_paginator($orders, 10);

        return view('dashboard.orders', compact('orders'));
    }

    public function orders_show($id)
    {
        $order = \App\Models\Order::findOrFail($id);

        $order->phone = \App\Services\Common::int_to_phone($order->phone);

        return view('dashboard.order', compact('order'));
    }

    public function order_update(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        $comment = $request->input('comment');

        $now = date('Y-m-d H:i:s');

        \App\Models\Order::where('id', $id)
                        ->update([
                            'status' => $status,
                            'comment' => $comment,
                            'updated_at' => $now
                        ]);

        return redirect('/admin/orders');
    }

    public function order_print($id)
    {   
        // методы order_print и order_check одинаковые
        if ($id) {
           
            // Получаю все товары по номеру заказа
            $products_array = \Illuminate\Support\Facades\DB::table('orders_products')->where('order_id', $id)->get();

            // Создаю массив с id товаров
            $products_id_array = [];
            foreach($products_array as $value) {
                $products_id_array[] = $value->product_id;
            }

            // Получаю товары по id
            $products = \App\Models\Product::whereIn('id', $products_id_array)->get();

            $total = [
                "quantity" => 0,
                "summ" => 0
            ];

            // Добавляю номер заказа, количество и сумма к каждому товару
            foreach($products as $value) {
                // Добавление номер заказа order_id
                $value->order_id = $products_array->where('product_id', $value->id)->value('order_id');

                // Добавление количества quantity
                $value->quantity = $products_array->where('product_id', $value->id)->value('quantity');

                // Расчет суммы одного товара
                if ($value->promo_price) {
                    $value->summ = $value->promo_price * $value->quantity;
                } else {
                    $value->summ = $value->retail_price * $value->quantity;
                }

                // Расчет количества всех товаров
                $total["quantity"] += $value->quantity;
                // Расчет суммы всех товаров
                $total["summ"] += $value->summ;
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

            return view('dashboard.order-print', compact('id', 'products'));

        } else {
            return view('dashboard.orders');
        }
    }

    public function order_check($id)
    {       
        if ($id) {
            // Получаю все товары по номеру заказа
            $products_array = \Illuminate\Support\Facades\DB::table('orders_products')->where('order_id', $id)->get();

            // Создаю массив с id товаров
            $products_id_array = [];
            foreach($products_array as $value) {
                $products_id_array[] = $value->product_id;
            }

            // Получаю товары по id
            $products = \App\Models\Product::whereIn('id', $products_id_array)->get();

            $total = [
                "quantity" => 0,
                "summ" => 0
            ];

            // Добавляю номер заказа, количество и сумма к каждому товару
            foreach($products as $value) {
                // Добавление номер заказа order_id
                $value->order_id = $products_array->where('product_id', $value->id)->value('order_id');

                // Добавление количества quantity
                $value->quantity = $products_array->where('product_id', $value->id)->value('quantity');

                // Расчет суммы одного товара
                if ($value->promo_price) {
                    $value->summ = $value->promo_price * $value->quantity;
                } else {
                    $value->summ = $value->retail_price * $value->quantity;
                }

                // Расчет количества всех товаров
                $total["quantity"] += $value->quantity;
                // Расчет суммы всех товаров
                $total["summ"] += $value->summ;
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

            return view('dashboard.order-check', compact('id', 'products', 'total'));

        } else {
            return view('dashboard.orders');
        }
    }

    public function testimonials_update(Request $request)
    {   
        $validated = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|min:3|max:150',
            'text' => 'required|min:3|max:1000',
        ]);

        $testimonial = \App\Models\Testimonial::findOrFail($validated["id"]);

        $testimonial->update([
                        'name' => $validated["name"],
                        'text' => $validated["text"],
                        'publicated_at' => now(),
                    ]);

        return redirect('/dashboard/testimonials');
    }

    public function testimonials_destroy(Request $request)
    {   
        $id = $request->input('id');

        $testimonial = \App\Models\Testimonial::find($id);

        // Удаление файла
        if ($testimonial->image) {
            if (\Illuminate\Support\Facades\Storage::exists($testimonial->image)) {
                \Illuminate\Support\Facades\Storage::delete($testimonial->image);
            }
        }

        $testimonial->delete();

        return redirect('/dashboard/testimonials');
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj()
    {
        $page = \App\Models\Page::where('id', 1)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj_update(Request $request)
    {
        $page = Page::where('id', 1)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function politika_konfidencialnosti()
    {
        $page = \App\Models\Page::where('id', 2)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function politika_konfidencialnosti_update(Request $request)
    {
        $page = Page::where('id', 2)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function garantiya_vozvrata_denezhnyh_sredstv()
    {
        $page = \App\Models\Page::where('id', 3)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function garantiya_vozvrata_denezhnyh_sredstv_update(Request $request)
    {
        $page = Page::where('id', 3)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function page_404(Request $request)
    {
        return view('dashboard.404');
    }
}
