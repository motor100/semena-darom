<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Testimonial;

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
        return view('kontakty');
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


    public function otzyvy_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:4|max:50',
            'email' => 'required|min:3|max:100',
            'text' => 'required|min:3|max:1000',
            'g-recaptcha-response' => 'required',
            'file' => [
                'nullable',
                \Illuminate\Validation\Rules\File::types(['jpg', 'png'])
                                                    ->min(50)
                                                    ->max(5 * 1024)
            ],

        ]);

        // Google Captcha
        $g_url = 'https://www.google.com/recaptcha/api/siteverify';

        $g_params = [
            'secret' => config('google.server_key'),
            'response' => $validated["g-recaptcha-response"],
        ];

        $g_response = \Illuminate\Support\Facades\Http::asForm()->post($g_url, $g_params);

        if (!$g_response->json('success')) {
            return false;
        }

        // Автоматически генерировать уникальный идентификатор для имени файла
        $path = \Illuminate\Support\Facades\Storage::putFile('public/testimonials', $validated["file"]);

        // URL для файла \Illuminate\Support\Facades\Storage::url($модель->image)

        return Testimonial::create([
                    'name' => $validated["name"],
                    'email' => $validated["email"],
                    'text' => $validated["text"],
                    'image' => $path
                ]);
    }

}
