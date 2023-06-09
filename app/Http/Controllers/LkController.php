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

        return view('lk.home');
    }
}
