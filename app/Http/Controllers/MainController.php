<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainSlider;
use App\Models\Promo;
use App\Models\Testimonial;
use Illuminate\Support\Str;


class MainController extends Controller
{
    public function home()
    {
        // Main slider
        $sliders = MainSlider::all();

        // Хит недели
        $hit_products = Product::whereNotNull('property')
                                ->take(3)
                                ->inRandomOrder()
                                ->get();

        // Акции
        $promos = Promo::orderBy('id', 'desc')
                        ->take(3)
                        ->get();
        
        /**
         * Новинки
         * Последние 10 товаров
         * Случайный порядок
         * Обрезка коллекции до 3
         * Заголовок title и описание text обрезаются через css
        */
        $new_products = Product::orderBy('id', 'desc')->limit(10)->get();

        $new_products = $new_products->shuffle()->slice(0, 3);

        return view('home', compact('sliders', 'hit_products', 'promos', 'new_products'));
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
        $testimonials = Testimonial::whereNotNull('publicated_at')
                                    ->orderBy('id', 'desc')
                                    ->paginate(20);

        return view('otzyvy', compact('testimonials'));
    }

    public function kontakty()
    {
        return view('kontakty');
    }

    public function catalog(Request $request)
    {
        $products = Product::where('stock', '>', 0);
        // $products = Product::query(); // без where

        $products = (new \App\Services\ProductFilter($products, $request))
                                            ->apply()
                                            ->paginate(30)
                                            ->withQueryString();

        $category_title = \App\Services\Common::get_category_title($request);

        return view('catalog', compact('products', 'category_title'));
    }

    /*
    public function catalog(Request $request)
    {
        // Get query param
        $query_category = $request->query('category');
        $query_sort = $request->query('sort');

        $query_category = htmlspecialchars($query_category);
        $query_sort = htmlspecialchars($query_sort);

        $order_by = "asc";
        if ($query_sort == "price-desc") {
            $order_by = "desc";
        }

        $category_title = "Каталог";
        
        if ($query_category) { // Если есть параметр category то получаю товары из этой категории
            
            if (mb_strlen($query_category) < 3 || mb_strlen($query_category) > 40) {
                return redirect('/catalog');
            }

            // Акции
            if ($query_category == 'akcii') {

                // Все товары у которых promo_price не NULL
                $products = Product::whereNotNull('promo_price')
                                    // ->limit(20)
                                    // ->get();
                                    ->orderBy('retail_price', $order_by)
                                    ->paginate(50)
                                    ->withQueryString();

                $category_title = 'Акции';
            }

            // Новинки
            if ($query_category == 'novinki') {

                // Последние 10 товаров
                $products = Product::orderBy('id', 'desc')
                                    // ->limit(20)
                                    // ->get();
                                    ->orderBy('retail_price', $order_by)
                                    ->paginate(50)
                                    ->withQueryString();

                $category_title = 'Новинки';
            }

            // Categories
            // Get all categories
            // $categories = \App\Models\Category::all();

            // Get parent categories
            // $parent_category = $categories->where('parent', '0');
            
            // Products
            // Get products with query param
            if ($query_category != 'akcii' && $query_category != 'novinki') {

                $category = '';

                if ($query_category) {
                    // $category = $categories->where('slug', $query_category)->first();
                    $category = \App\Models\Category::where('slug', $query_category)->first();
                }

                if ($category) {
                    $products = Product::where('category_id', $category->id)
                                        ->orderBy('id', 'desc')
                                        ->paginate(50)
                                        ->withQueryString();

                    $category_title = $category->title;
                } else {
                    return redirect('/catalog');
                }
            }

        } else { // Если нет параметра category, то вывожу все товары
            $products = Product::orderBy('id', 'desc')
                                // ->limit(20)
                                // ->get();
                                ->paginate(50);
        }

        return view('catalog', compact('products', 'category_title', 'query_category', 'query_sort'));
    }
    */

    public function akcii(Request $request)
    {
        $products = Product::where('stock', '>', 0)
                            ->whereNotNull('promo_price');
        
        if ($request->has('price')) {

            if ($request->price != "desc" && $request->price != "asc") {
                return redirect('/akcii');
            }

            $products = $products->orderBy('retail_price', $request->price);
        }
        
        $products = $products->paginate(30)->withQueryString();

        return view('akcii', compact('products'));
    }

    public function novinki(Request $request)
    {
        $products = Product::where('stock', '>', 0)
                            ->take(150);
        
        if ($request->has('price')) {

            if ($request->price != "desc" && $request->price != "asc") {
                return redirect('/novinki');
            }

            $products = $products->orderBy('retail_price', $request->price);
        }
        
        $products = $products->paginate(30)->withQueryString();

        return view('novinki', compact('products'));
    }

    public function single_product($slug)
    {
        if (strlen($slug) > 3 && strlen($slug) < 100) {

            $product = Product::where('slug', $slug)->first();

            if ($product) {
                $product->retail_price = str_replace('.0', '', $product->retail_price);
                $product->promo_price = str_replace('.0', '', $product->promo_price);
                
                // Заголовок в 2 цвета
                // функция в common
                $words_array = explode(" ", $product->title);
                if (count($words_array) > 1) {
                    $first_word = "<span class=\"grey-text\">" . $words_array[0] . "</span>";
                    $words_array[0] = $first_word;
                    $product->color_title = implode(" ", $words_array);
                } else {
                    $product->color_title = "<span class=\"grey-text\">" . $product->title . "</span>";
                }

                $product->category = \App\Models\Category::where('id', $product->category_id)->first();

                $product->recommend_products = Product::where('category_id', $product->category_id)
                                                        ->inRandomOrder()
                                                        ->limit(3)
                                                        ->get();

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
            $keys = array_keys($favorites_item);
            $products = Product::whereIn('id', $keys)->get();
        }

        return view('favourites', compact('products'));
    }

    public function rm_from_favourites(Request $request)
    {
        // Метод pull извлекает и удаляет элемент из сессии единым выражением
        $request->session()->pull("favourites." . $request->input("id"), "default");

        return redirect('/favourites');
    }

    public function clear_favourites()
    {
        session()->pull('favourites', 'default');
        return redirect('/favourites');
    }

    public function cart(Request $request)
    {
        // Переменная is_cart переключения макета корзины справа и внизу при ширине менее 1400px
        $is_cart = true;

        // $request->cookie('cart') получение товаров из куки

        $products = \App\Services\Common::get_products_in_cart($request);

        return view('cart', compact('products', 'is_cart'));
    }

    public function create_order(Request $request)
    {
        // Переменная is_cart переключения макета корзины справа и внизу при ширине менее 1400px
        $is_cart = true;

        if ($request->session()->has('cart')) {

            $products = \App\Services\Common::get_products_in_cart($request);

            return view('create_order', compact('products'));
        } else {
            return redirect('/cart');
        }
    }

    public function poisk(Request $request)
    {
        $search_query = $request->input('search_query');

        if (mb_strlen($search_query) < 3 || mb_strlen($search_query) > 40) {
            return redirect('/');
        }

        $search_query = htmlspecialchars($search_query);

        if (!$search_query) {
            return redirect('/');
        }

        $search_query = htmlspecialchars($search_query);

        $products = Product::where('title', 'like', "%{$search_query}%")
                            ->orWhere('text', 'like', "%{$search_query}%")
                            ->get();

        if (!$products) {
            return redirect('/');
        };

        return view('poisk', compact('products', 'search_query'));
    }

    public function rm_from_cart(Request $request)
    {   
        // Метод pull извлекает и удаляет элемент из сессии единым выражением
        $request->session()->pull("cart." . $request->input("id"), "default");

        return redirect('/cart');
    }

    public function clear_cart(Request $request)
    {
        $redirect_url = $request->headers->get('referer');

        session()->pull('cart', 'default');

        return $redirect_url ? redirect($redirect_url) : redirect('/');
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

    public function kak_oformit_zakaz()
    {
        return view('kak_oformit_zakaz');
    }

    public function ajax_search(Request $request)
    {
        $search_query = $request->input('search_query');

        if (!$search_query) {
            return response()->json(['message' => 'error']);
        }

        $search_query = htmlspecialchars($search_query);

        $products = Product::where('title', 'like', "%{$search_query}%")
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

        $cart_items = [];

        if ($request->session()->has('cart')) { // Если есть сессия cart, то добавляю в конец массива

            $cart_items = $request->session()->get('cart');

            if (array_key_exists($id, $cart_items)) { // Если есть товар, то прибавляю количество
                $cart_items[$id] = $cart_items[$id] + 1;
            } else {
                $cart_items[$id] = 1;
            }

        } else { // Если нет, то создаю массив и добавляю туда значение
            $cart_items[$id] = 1;
        }

        $request->session()->put('cart', $cart_items);

        $keys = array_keys($cart_items);

        $products_array = [];

        // Получение моделей товаров
        $products = Product::whereIn('id', $keys)->get();

        // Количество каждого товара
        foreach ($products as $product) {
            $product->quantity = $cart_items[$product->id];
        }

        $products_array["products"] = $products;

        $products_array["cart_count"] = count($request->session()->get('cart'));

        if ($products_array["cart_count"] > 9) {
            $products_array["cart_count"] = 9;
        }

        // return $cart_count;
        return response()->json($products_array);
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

            if (array_key_exists($id, $favourites_items)) { // Если есть товар, то прибавляю количество
                $favourites_items[$id] = $favourites_items[$id] + 1;
            } else {
                $favourites_items[$id] = 1;
            }

        } else { // Если нет, то создаю массив favourites и добавляю туда значение
            $favourites_items[$id] = 1;
        }

        $request->session()->put('favourites', $favourites_items);

        $favourites_count = count($request->session()->get('favourites'));

        // Количество товара в избранном более 9
        if ($favourites_count > 9) {
            $favourites_count = 9;
        }

        return $favourites_count;
    }

    public function ajax_testimonial(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json(['message' => 'error']);
        }

        $validated = $validator->validated();

        // Google Captcha
        $g_url = 'https://www.google.com/recaptcha/api/siteverify';

        $g_params = [
            'secret' => config('google.server_key'),
            'response' => $validated["g-recaptcha-response"],
        ];

        $g_response = \Illuminate\Support\Facades\Http::asForm()->post($g_url, $g_params);

        if (!$g_response->json('success')) {
            return response()->json(['message' => 'error']);
        }

        $path = NULL;

        if (array_key_exists("file", $validated)) {
            // Автоматически генерировать уникальный идентификатор для имени файла
            $path = \Illuminate\Support\Facades\Storage::putFile('public/uploads/testimonials', $validated["file"]);
        }

        $testimonial = Testimonial::create([
                    'name' => $validated["name"],
                    'email' => $validated["email"],
                    'text' => $validated["text"],
                    'image' => $path,
                    'publicated_at' => NULL
                ]);

        return response()->json($testimonial);

    }

    public function ajax_we_use_cookie(Request $request)
    {
        // Через экземпляр запроса
        // $request->session()->put('we-used-cookie', 'yes');

        // Через глобальный помощник «session»
        // session(['we-used-cookie' => 'yes']);

        // $request->session()->put('we-used-cookie', 'yes');
        // $request->cookie('we-used-cookie', 'yes', 525600);
        // \Illuminate\Support\Facades\Cookie::put('name', 'Fred', 60);
        // \Illuminate\Support\Facades\Cookie::put('we-used-cookie', 'yes', 525600);

        // return false;
        return response()
                ->json(['previousCookieValue' => \Illuminate\Support\Facades\Cookie::get('we-used-cookie')])
                ->withCookie(cookie('we-used-cookie', 'yes', 525600));
    }

    public function ajax_city(Request $request)
    {
        $city = $request->input('city');

        // Через экземпляр запроса
        $request->session()->put('city', $city);

        // Через глобальный помощник «session»
        // session(['we-used-cookie' => 'yes']);
        return response()->json(['message' => 'error']);
        return false;
    }
}
