<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MainController extends Controller
{
    public function home()
    {   
        $products = Product::limit(10)->get();
        
        return view('home', compact('products'));
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
        $page = \App\Models\Page::where('id', 2)->first();

        return view('text-page', compact('page'));
    }
    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj()
    {
        $page = \App\Models\Page::where('id', 1)->first();

        return view('text-page', compact('page'));
    }
    public function garantiya_vozvrata_denezhnyh_sredstv()
    {
        $page = \App\Models\Page::where('id', 3)->first();

        return view('text-page', compact('page'));
    }
}
