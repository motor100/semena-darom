<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainSlider;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function home()
    {   
        // Main slider
        $sliders = MainSlider::all();
        
        // Products
        $products = Product::limit(3)->get();

        $products->each(function ($item, $key) {
            $item->short_title = Str::limit($item->title, 38, '...');
            $item->short_text = Str::limit($item->text, 60, '...');
            $item->retail_price = str_replace('.0', '', $item->retail_price);
            $item->promo_price = str_replace('.0', '', $item->promo_price);
        });
        
        return view('home', compact('sliders', 'products'));
    }

    public function o_kompanii()
    {
        return view('o_kompanii');
    }

    public function dostavka_i_oplata()
    {
        return view('dostavka_i_oplata');
    }

    public function otzyvy()
    {
        $testimonials = Testimonial::limit(60)->orderBy('id', 'desc')->get();

        $testimonials->each(function ($item) {
            $item->short_created_at = $item->created_at->format("d.m.Y");
        });

        $testimonials = \App\Services\Common::custom_paginator($testimonials, 10);

        return view('otzyvy', compact('testimonials'));
    }

    public function kontakty()
    {
        return view('kontakty');
    }

    public function catalog()
    {
        // Categories
        // Get all categories
        $categories = \App\Models\Category::all();

        return view('catalog', compact('categories'));
    }

    public function single_product($slug)
    {
        if (is_string($slug) && strlen($slug) > 3 && strlen($slug) < 100) {

            $single_product = Product::where('slug', $slug)->first();
            $single_product->retail_price = str_replace('.0', '', $single_product->retail_price);
            $single_product->promo_price = str_replace('.0', '', $single_product->promo_price);

            if ($single_product) {
                return view('single_product', compact('single_product'));
            } else {
                return abort(404);
            }
        } else {
            return redirect('/');
        }
    }

    public function favourites(Request $request)
    {
        $products = [];

        if ($request->session()->has('favourites')) {
            $favorites_item = $request->session()->get('favourites');
            $products = Product::whereIn('id', $favorites_item)->get();
        }

        return view('favourites', compact('products'));
    }

    public function cart(Request $request)
    {
        $cart_items = $request->session()->get('cart');

        $products = collect();

        if ($cart_items) {
            $key_items = array_keys($cart_items);

            $products = Product::whereIn('id', $key_items)->get();

            foreach ($products as $pr) {
                if ($pr->stock > 0) {
                    $products[] = $pr;
                }
            }

            foreach ($products as $pr => $value) {
                $id = $value->id;
                $value->quantity = $cart_items[$id];
                $value->count = $pr;
            }
        }

        return view('cart', compact('products'));
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

    public function kak_zakazat()
    {
        return view('kak_zakazat');
    }

    public function poisk(Request $request)
    {
        // Search
        $q = $request->input('q');

        if (!$q) {
            return redirect('/');
        }

        $q = htmlspecialchars($q);

        $products = Product::where('title', 'like', "%{$q}%")
                            ->orWhere('text', 'like', "%{$q}%")
                            ->get();

        if (!$products) {
            return redirect('/');
        };

        return view('poisk', compact('products', 'q'));
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

    public function ajax_search(Request $request)
    {
        $product = $request->input('q');

        if (!$product) {
            return response()->json(['message' => 'error']);
        }

        $product = htmlspecialchars($product);

        $products = Product::where('title', 'like', "%{$product}%")
                            // если нужен поиск по тексту
                            // ->orWhere('text', 'like', "%{$product}%") 
                            ->get();

        $products_array = [];

        if ($products && count($products) > 0) {
            foreach ($products as $value) {
                $product_item = [];
                $product_item['title'] = $value->title;
                $product_item['slug'] = $value->slug;
                $products_array[] = $product_item;
            }
        } else {
            return response()->json(['message' => 'not found']);
        }

        return response()->json($products_array);
    }

    public function ajax_city_select(Request $request)
    {
        $city = $request->input('city');

        if (!$city) {
            return response()->json(['message' => 'error']);
        }

        $city = htmlspecialchars($city);

        $cities = \App\Models\City::where('city', 'like', "%{$city}%")->get();

        $cities_array = [];

        if ($cities && count($cities) > 0) {
            foreach ($cities as $value) {
                $city_item = [];
                $city_item['city'] = $value->city;
                $city_item['region'] = $value->region;
                $cities_array[] = $city_item;
            }
        } else {
            return response()->json(['message' => 'not found']);
        }

        return response()->json($cities_array);
    }

    public function ajax_add_to_favourites(Request $request)
    {
        $id = $request->input('id');

        if ($request->session()->has('favourites')) { // Если есть в сессии favourites, то добавляю в конец массива
            $favourites_items = $request->session()->get('favourites');

            $has_product = false;
            foreach($favourites_items as $value) {
                if ($value == $id) {
                    $has_product = true;
                }
            }

            if (!$has_product) { // Если такого ключа с id нет в массиве, то добавляю
                $favourites_items[] = $id;
                $request->session()->put('favourites', $favourites_items);
            }
        } else { // Если нет, то создаю массив favourites и добавляю туда значение 
            $request->session()->put('favourites', [$id]);
        }

        $favourites_count = count($request->session()->get('favourites'));

        return $favourites_count;
    }

}
