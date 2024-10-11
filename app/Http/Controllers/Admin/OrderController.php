<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = \App\Models\Order::orderBy('id', 'desc')
                                    ->limit(200)
                                    ->get();
        
        $orders = \App\Services\Common::custom_paginator($orders, 50);

        return view('dashboard.orders', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $order = \App\Models\Order::findOrFail($id);

        $order->phone = \App\Services\Common::int_to_phone($order->phone);

        // Получаю модель CdekOrder по номеру заказа
        $cdek_order = \App\Models\CdekOrder::where('order_id', $id)->first();

        $is_waybill = false;

        // Если есть модель СdekOrder с таким order_id
        if ($cdek_order) {
            // Сравниваю updated_at с текущей датой и получаю разницу в минутах
            $diff_minutes = $cdek_order->updated_at->diffInMinutes(now());

            // 1 минута - время на формирование квитанции
            // 60 минут - ссылка на файл с квитанцией действует 1 час
            if ($diff_minutes > 1 && $diff_minutes < 60) {
                $is_waybill = true;
            }
        }

        return view('dashboard.order-show', compact('order', 'is_waybill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
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

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Prepare to print
     * @param string $id
     * @return Illuminate\View\View
     */
    public function print(string $id): View
    {
        // Получаю модель заказа
        $order = \App\Models\Order::findOrFail($id);

        // Сортировка товаров в отдельном классе
        $products = (new \App\Services\ProductSort($order))->get();

        return view('dashboard.order-print', compact('id', 'products'));
    }

    /**
     * Check order and listing products
     * @param string $id
     * @return Illuminate\View\View
     */
    public function check(string $id): View
    {
        // Получаю модель заказа
        $order = \App\Models\Order::findOrFail($id);
        
        // Сортировка товаров в отдельном классе
        $products = (new \App\Services\ProductSort($order))->get();

        $total = [
            "quantity" => 0,
            "summ" => 0
        ];

        foreach($products as $product) {
            // Расчет количества всех товаров
            $total["quantity"] += $product->pivot->quantity;
            // Расчет суммы всех товаров
            $total["summ"] += $product->summ;
        }
        
        return view('dashboard.order-check', compact('id', 'products', 'total'));
    }
}
