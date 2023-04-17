<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {   
        return view('home');
    }

    public function o_kompanii()
    {
        $text = '';

        return view('o_kompanii', compact('text'));
    }
    public function dostavka_i_oplata()
    {
        $text = '';

        return view('dostavka_i_oplata', compact('text'));
    }
    public function otzyvy()
    {
        $text = '';

        return view('otzyvy', compact('text'));
    }
    public function kontakty()
    {
        $text = '';

        return view('kontakty', compact('text'));
    }
    public function catalog()
    {
        $text = '';

        return view('catalog', compact('text'));
    }
    public function cart()
    {
        $text = '';

        return view('cart', compact('text'));
    }
    public function politika_konfidencialnosti()
    {
        $text = '';

        return view('politika_konfidencialnosti', compact('text'));
    }
    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj()
    {
        $text = '';

        return view('polzovatelskoe_soglashenie_s_publichnoj_ofertoj', compact('text'));
    }
    public function garantiya_vozvrata_denezhnyh_sredstv()
    {
        $text = '';

        return view('garantiya_vozvrata_denezhnyh_sredstv', compact('text'));
    }
}
