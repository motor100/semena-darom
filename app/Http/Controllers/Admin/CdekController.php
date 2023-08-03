<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CdekController extends Controller
{
    public function cdek_create_order($id)
    {
        // Получаю модель заказа
        $order = \App\Models\Order::findOrFail($id);
        
        // Формирую заказ
        $cdek_order = (new \App\Services\Cdek())->create_order($order);

        // Создаю/обновляю модель CdekOrder
        \App\Models\CdekOrder::updateOrCreate(
            ['order_id' => $order->id],
            ['uuid' => $cdek_order["entity"]["uuid"], 'waybill_uuid' => $cdek_order["related_entities"][0]["uuid"], 'updated_at' => now() ]
        );

        // uuid заказа
        // return $cdek_order["entity"]["uuid"];

        // uuid квитанции для этого заказа
        // return $cdek_order["related_entities"][0]["uuid"];

        return redirect()->back()->with('status', 'Заказ отправлен в СДЕК. Для получения квитанции обновите страницу через некоторое время.');
    }

    public function cdek_download_waybill($id)
    {
        // Получаю квитанцию
        $filename = (new \App\Services\Cdek())->get_waybill($id);

        // Скачиваю квитанцию
        return response()
                ->download('storage/print-forms/' . $filename)
                ->deleteFileAfterSend(true);
    }
}