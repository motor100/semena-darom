<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LkController extends Controller
{
    public function home(Request $request)
    {       
        // Пользователь
        $user = Auth::user();

        // Если пользователя нет, то редирект на главную
        if (!$user) {
            return redirect('/');
        }

        // Заказы
        $orders = \App\Models\Order::where('user_id', $user->id)
                                    ->paginate(20)
                                    ->onEachSide(1);

        return view('lk.home', compact('orders'));
    }

    public function order($id)
    {
        // Пользователь
        $user = Auth::user();
        
        // Заказы
        $orders = \App\Models\Order::where('user_id', $user->id)
                                    ->paginate(20)
                                    ->onEachSide(1);

        // Заказ
        $order = $orders->find($id);

        // Если пользователя и заказа нет, то редирект на /lk
        if (!$user || !$order) {
            return redirect('/lk');
        }

        return view('lk.order', compact('orders', 'order'));
    }
}
