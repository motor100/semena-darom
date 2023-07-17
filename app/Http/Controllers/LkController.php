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
        $orders = \App\Models\Order::where('user_id', $user->id)->get();

        return view('lk.home', compact('orders'));
    }
}
