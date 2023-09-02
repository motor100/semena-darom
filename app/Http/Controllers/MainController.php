<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainSlider;
use App\Models\Promo;
use App\Models\Testimonial;


class MainController extends Controller
{
    public function home()
    {
        // Main slider
        $sliders = MainSlider::all();

        // Хит недели
        $hit_products = Product::whereNotNull('property')
                                ->take(4)
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

        $new_products = $new_products->shuffle()->slice(0, 4);

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
                $product->color_title = (new \App\Services\SingleProduct($product->title))->double_color_title();

                $product->category = \App\Models\Category::where('id', $product->category_id)->first();

                $product->recommend_products = Product::where('category_id', $product->category_id)
                                                        ->inRandomOrder()
                                                        ->limit(3)
                                                        ->get();

                // Ограничение количества элементов в коллекции галерея
                $product->galleries->slice(0, 3);

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
        $products = collect();

        if ($request->hasCookie('favourites')) {

            // Получение куки через фасад Cookie метод get
            $favourites = json_decode(\Illuminate\Support\Facades\Cookie::get('favourites'), true);

            $keys = array_keys($favourites);

            $products = Product::whereIn('id', $keys)->get();
        }

        return view('favourites', compact('products'));
    }

    public function rm_from_favourites(Request $request)
    {
        $id = $request->input('id');

        if ($request->hasCookie('favourites') && $id) {

            // Получение куки через фасад Cookie метод get
            $favourites = json_decode(\Illuminate\Support\Facades\Cookie::get('favourites'), true);

            // Удаляю ключ из массива если он существует
            if (array_key_exists($id, $favourites)) {
                unset($favourites[$id]);
            }

            $favourites_json = json_encode($favourites);

            // Записываю новый массив в куки через фасад Cookie метод queue
            \Illuminate\Support\Facades\Cookie::queue('favourites', $favourites_json, 525600);

        }

        return redirect('/favourites');
    }

    public function clear_favourites()
    {
        // Удаление из куки favourites через фасад Cookie метод forget
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('favourites'));

        return redirect('/favourites');
    }

    public function cart(Request $request)
    {
        // Переменная is_cart переключения макета корзины справа и внизу при ширине менее 1400px
        $is_cart = true;

        $products = \App\Services\Common::get_products_in_cart($request);

        return view('cart', compact('products', 'is_cart'));
    }

    public function create_order(Request $request)
    {
        // Переменная is_create_order переключение текста кнопки Оформить заказ
        $is_create_order = true;

        // Получение куки через фасад Cookie метод get
        $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

        if ($cart) {

            $products = \App\Services\Common::get_products_in_cart($request);

            return view('create_order', compact('products', 'is_create_order'));
        } else {
            return redirect('/cart');
        }
    }

    public function create_order_handler(Request $request)
    {
        $validated = $request->validate([
            'delivery' => 'required',
            'first-name'=> 'required|min:3|max:20',
            'last-name'=> 'required|min:3|max:30',
            'phone'=> 'required|size:18',
            'email'=> 'required|min:5|max:50',
            'address'=> 'required|min:5|max:150',
            'payment' => 'required',
            'summ' => 'required|numeric',
        ]);

        // Телефон из строки в цисло
        $phone = \App\Services\Common::phone_to_int($validated['phone']);

        // Получение аутентифицированного пользователя
        $user = $request->user();

        // Вставить city_id
        // Создаю новую модель Order и получаю id новой записи
        $order_id = \App\Models\Order::insertGetId([
            'first_name' => $validated['first-name'],
            'last_name' => $validated['last-name'],
            'phone'=> $phone,
            'email'=> $validated['email'],
            'address'=> $validated['address'],
            'price' => $validated['summ'],
            'user_id' => $user ? $user->id : NULL,
            'status' => 'В обработке',
            'comment' => NULL,
            'delivery' => $validated['delivery'],
            'payment' => $validated['payment'],
            'payment_status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Получение куки через фасад Cookie метод get
        $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);
        
        $insert_array = [];

        foreach($cart as $key => $value) {
            $row['order_id'] = $order_id;
            $row['product_id'] = $key;
            $row['quantity'] = $value;
            $row['created_at'] = now();
            $row['updated_at'] = now();
            $insert_array[] = $row;
        }

        // Создание моделей OrderProduct
        \App\Models\OrderProduct::insert($insert_array);

        // Удаление куки
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('cart'));
        
        // Редирект на страницу оплаты
        return redirect()
                ->route('thankyou', [
                    'order_id' => $order_id,
                    'summ' => $validated['summ'],
                    'payment' => $validated['payment']
                ]);
    }

    public function thankyou(Request $request)
    {
        if ($request->has('order_id') && $request->has('summ')) {

            $order_id = $request->input('order_id');
            $summ = $request->input('summ');
            $payment = $request->input('payment');

            return view('thankyou', compact('order_id', 'summ', 'payment'));
        } else {
            return view('thankyou');
        }

        // Для юкассы
        // $summ - сумма к оплате
        // $order_id - номер заказа
        // http://semena-darom1.ru/thankyou?order_number=5&summ=1865 - ссылка для редиректа после оплаты
        // без параметра payment
        // $request->url() . '?order_id=' . $order_id . '&summ=' . $summ
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
        $id = $request->input('id');

        if ($request->hasCookie('cart') && $id) {

            // Получение куки через фасад Cookie метод get
            $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

            // Удаляю ключ из массива если он существует
            if (array_key_exists($id, $cart)) {
                unset($cart[$id]);
            }

            $cart_json = json_encode($cart);

            // Записываю новый массив в куки через фасад Cookie метод queue
            \Illuminate\Support\Facades\Cookie::queue('cart', $cart_json, 525600);
        }

        return redirect('/cart');
    }

    public function clear_cart(Request $request)
    {
        $redirect_url = $request->headers->get('referer');

        // Удаляю из куки cart через фасад Cookie метод forget
        \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('cart'));

        return $redirect_url ? redirect($redirect_url) : redirect('/');
    }

    public function politika_konfidencialnosti()
    {
        return view('politika-konfidencialnosti');
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj()
    {
        return view('polzovatelskoe-soglashenie-s-publichnoj-ofertoj');
    }

    public function garantiya_vozvrata_denezhnyh_sredstv()
    {
        return view('garantiya-vozvrata-denezhnyh-sredstv');
    }

    public function kak_oformit_zakaz()
    {
        return view('kak_oformit_zakaz');
    }

    public function set_city(Request $request)
    {
        $redirect_url = $request->headers->get('referer');
        
        if ($request->has('city_id')) {

            $city_id = $request->input('city_id');

            $city = \App\Models\City::where('id', $city_id)->first();

            $city_array = [
                'id' => $city["id"],
                'city' => $city["city"]
            ];

            $city_json = json_encode($city_array);

            // Установка куки через фасад Cookie метод queue
            \Illuminate\Support\Facades\Cookie::queue('city', $city_json, 525600);
        }

        return $redirect_url ? redirect($redirect_url) : redirect('/');
    }
    
    public function page_404(Request $request)
    {
        // Получаю текущий URL без доменного имени
        $requestUri = $request->getRequestUri();

        // Проверить аутентификацию админа через guard('admin')
        // \Illuminate\Support\Facades\Auth::guard('admin')->check();

        // Если строка содержит admin
        if (str_contains($requestUri, "admin")) {
            // Редирект на страницу 404. Она должна быть в routes/admin.php
            return redirect('/admin/page-404');
        }

        // Если строка содержит lk
        if (str_contains($requestUri, "lk")) {
            return view('lk.404');
        }
        
        // Во всех других случаях
        return abort(404);
    }

    public function sitemap()
    {
        $products = Product::select('slug')->get();

        return response()
                ->view('sitemap', compact('products'))
                ->header('Content-Type', 'text/xml');
    }
}
