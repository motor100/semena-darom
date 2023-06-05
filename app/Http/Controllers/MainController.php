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

    public function catalog(Request $request)
    {
        // Get query param
        $query_category = $request->query('category');
        
        // Categories
        // Get all categories
        $categories = \App\Models\Category::all();

        // Get parent categories
        $parent_category = $categories->where('parent', '0');

        // Products
        // Get products with query param
        $category = false;
        if($query_category) {
            $category = $categories->where('slug', $query_category)->first();
        }
        
        if($category) {
            $products = Product::where('category_id', $category->id)->orderBy('id', 'desc')->get();
            $products_count = $products->count();
            $products = $products->take(20);
            $category_title = $category->title;

            $step = 20;
            $page_max = ceil( $products_count / $step);

            return view('catalog', compact('products', 'parent_category', 'category_title', 'products_count', 'page_max'));
        } else {
            $products = Product::orderBy('id', 'desc')->get();
            $products_count = $products->count();
            $products = $products->take(20);

            $step = 20;
            $page_max = ceil( $products_count / $step);

            return view('catalog', compact('products', 'parent_category', 'products_count', 'page_max'));
        }
    }

    public function single_product($slug)
    {
        if (strlen($slug) > 3 && strlen($slug) < 100) {

            $product = Product::where('slug', $slug)->first();

            if ($product) {
                $product->retail_price = str_replace('.0', '', $product->retail_price);
                $product->promo_price = str_replace('.0', '', $product->promo_price);
                
                // Заголовок в 2 цвета
                $words_array = explode(" ", $product->title);
                if (count($words_array) > 1) {
                    $first_word = "<span class=\"grey-text\">" . $words_array[0] . "</span>";
                    $words_array[0] = $first_word;
                    $product->color_title = implode(" ", $words_array);
                } else {
                    $product->color_title = "<span class=\"grey-text\">" . $product->title . "</span>";
                }

                return view('single_product', compact('product'));
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

    public function clear_favourites()
    {
        session()->pull('favourites', 'default');
        return redirect('/favourites');
    }

    public function cart(Request $request)
    {
        $products = [];

        if ($request->session()->has('cart')) {

            $cart_items = $request->session()->get('cart');

            $keys = array_keys($cart_items);

            // Получение моделей товаров
            $products = Product::whereIn('id', $keys)->get();
            
            // Предзаказ
            // foreach ($products as $product) {
            //     if ($product->stock > 0) {
            //         $products[] = $product;
            //     }
            // }
            
            // Количество каждого товара
            foreach ($products as $product) {
                $product->quantity = $cart_items[$product->id];
                // $product->count = $product;
            }

            $products->each(function ($item) {
                $item->retail_price = str_replace('.0', '', $item->retail_price);
                $item->promo_price = str_replace('.0', '', $item->promo_price);
            });
        }

        return view('cart', compact('products'));
    }

    public function rm_from_cart(Request $request)
    {   
        $id = $request->input('id');

        // Метод pull извлекает и удаляет элемент из сессии единым выражением
        $request->session()->pull('cart.' . $id, 'default');

        // $cart_count = count($request->session()->get('cart'));

        // return $cart_count;
        return redirect('/cart');
    }

    public function clear_cart()
    {
        session()->pull('cart', 'default');
        return redirect('/cart');
    }

    public function politika_konfidencialnosti()
    {
        // $page = \App\Models\Page::where('id', 2)->first();

        // return view('text-page', compact('page'));
        return view('politika-konfidencialnosti');
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj()
    {
        // $page = \App\Models\Page::where('id', 1)->first();

        // return view('text-page', compact('page'));

        return view('polzovatelskoe-soglashenie-s-publichnoj-ofertoj');
    }

    public function garantiya_vozvrata_denezhnyh_sredstv()
    {
        // $page = \App\Models\Page::where('id', 3)->first();

        // return view('text-page', compact('page'));
        return view('garantiya-vozvrata-denezhnyh-sredstv');
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

    public function ajax_add_to_cart(Request $request)
    {
        $id = $request->input('id');

        if ($request->session()->has('cart')) { // Если есть сессия cart, то добавляю в конец массива

            $cart_items = $request->session()->get('cart');

            if (array_key_exists($id, $cart_items)) { // Если есть товар, то прибавляю количество
                $cart_items[$id] = $cart_items[$id] + 1;
            } else {
                $cart_items[$id] = 1;
            }

        } else { // Если нет, то создаю массив и добавляю туда значение
            $cart_items = [];
            $cart_items[$id] = 1;
        }

        $request->session()->put('cart', $cart_items);

        $cart_count = count($request->session()->get('cart'));

        // Количество товара в корзине более 9
        if ($cart_count > 9) {
            $cart_count = 9;
        }

        return $cart_count;
    }

    public function ajax_plus_cart(Request $request)
    {   
        $id = $request->input('id');

        $cart_items = $request->session()->get('cart');

        $cart_items[$id] = $cart_items[$id] + 1;

        $request->session()->put('cart.' . $id, $cart_items[$id]);

        return false;
    }

    public function ajax_minus_cart(Request $request)
    {   
        $id = $request->input('id');

        $cart_items = $request->session()->get('cart');

        $cart_items[$id] = $cart_items[$id] - 1;
        
        if ($cart_items[$id] > 1) {
            $request->session()->put('cart.' . $id, $cart_items[$id]);
        }

        return false;
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

        // Количество товара в избранном более 9
        if ($favourites_count > 9) {
            $favourites_count = 9;
        }

        return $favourites_count;
    }

}
