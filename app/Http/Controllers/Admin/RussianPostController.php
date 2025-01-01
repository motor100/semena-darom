<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\RussianPost;

class RussianPostController extends Controller
{
    /**
     * Создание заказа Почта России
     *
     * @param integer $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function create_order($id)
    {
        $order = Order::findOrFail($id);

        $russian_post = new RussianPost();

        return $russian_post->create_order($order);
    }
}