<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CdekController extends Controller
{
    /**
     * Создание заказа СДЕК
     * 
     * @param integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function cdek_create_order($id): RedirectResponse
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

    /**
     * Скачать квитанцию СДЕК
     * @param integer $id
     * @return Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function cdek_download_waybill($id): BinaryFileResponse
    {
        // Получаю квитанцию
        $filename = (new \App\Services\Cdek())->get_waybill($id);

        // Скачиваю квитанцию
        return response()
                ->download('storage/print-forms/' . $filename)
                ->deleteFileAfterSend(true);
    }
}