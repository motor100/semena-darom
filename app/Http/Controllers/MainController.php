<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainSlider;
use App\Models\Promo;
use App\Models\Testimonial;
use Illuminate\View\View;


class MainController extends Controller
{
    public function home()
    {
        // Main slider LIFO
        $sliders = MainSlider::orderby('id', 'desc')->get();

        // Хит недели
        $hit_products = Product::whereNotNull('property')
                                ->take(4)
                                ->inRandomOrder()
                                ->get();

        // Акции
        $promos = Promo::orderBy('id', 'desc')
                        ->take(4)
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
                                    ->paginate(20)
                                    ->onEachSide(1);

        return view('otzyvy', compact('testimonials'));
    }

    public function kontakty()
    {
        return view('kontakty');
    }

    public function old_catalog(Request $request)
    {   
        $products = Product::where('stock', '>', 0);
        // $products = Product::query(); // без where

        $products = (new \App\Services\ProductFilter($products, $request))
                                            ->apply()
                                            // ->orderBy('id', 'desc')
                                            ->paginate(40)
                                            ->onEachSide(1)
                                            ->withQueryString();

        $category_title = \App\Services\Common::get_category_title($request);

        return view('catalog', compact('products', 'category_title'));
    }

    public function catalog()
    {   
        return view('catalog');
    }

    /**
     * Категория каталога
     * Поиск по slug модель \App\Models\Category метод getRouteKeyName()
     * 
     * @param \Illuminate\Http\Request $request;
     * @param  \App\Models\Category $category
     * @return \Illuminate\View\View
     */
    public function category(Request $request, Category $category = null): View
    {
        if ($category) {

            $child_categories = collect();

            if ($category->parent == 0) { // Если это родительская категория, то вывожу все ее дочерние категории и все товары из них

                // Дочерние категории
                $child_categories = Category::where('parent', $category->id)
                                            ->orderBy('title')
                                            ->get();

                // Товары из дочерних категорий
                // Метод pluck('id') выводит коллекцию из id
                $products = Product::whereIn('category_id', $child_categories->pluck('id'));

            } else { // Если это дочерняя категория, вывожу все товары из нее

                // Товары из родительской категории
                $products = Product::where('category_id', $category->id);
            }

            // Сортировка по полю price
            if ($request->has('price')) {
                if ($request->price == "desc" || $request->price == "asc") {
                    $products = $products->orderBy('retail_price', $request->price);
                }
            }

            // Пагинация
            $products = $products->paginate(40)->onEachSide(1);

            return view('category', compact('category', 'child_categories', 'products'));
        }

        return abort(404);
    }

    /**
     * Акции
     * Все товары с ценой в поле promo_price
     * 
     * @param \Illuminate\Http\Request $request;
     * @return \Illuminate\View\View
     */
    public function akcii(Request $request): View
    {
        $products = Product::where('stock', '>', 0)
                            ->whereNotNull('promo_price');
        
        if ($request->has('price')) {
            if ($request->price == "desc" || $request->price == "asc") {
                $products = $products->orderBy('retail_price', $request->price);
            }
        }
        
        $products = $products->paginate(40)->onEachSide(1)->withQueryString();

        return view('akcii', compact('products'));
    }

    /**
     * Новинки
     * Последние 60 товаров с сортировкой по id
     * 
     * @param \Illuminate\Http\Request $request;
     * @return \Illuminate\View\View
     */
    public function novinki(Request $request): View
    {
        // Последние 60 товаров
        $products = Product::where('stock', '>', 0)
                            ->orderBy('id', 'desc')
                            ->limit(60)
                            ->get();
        
        // Сортировка коллекции 
        if ($request->has('price')) {
            if ($request->price == "asc") {
                $products = $products->sortBy('retail_price');
            } else {
                $products = $products->sortByDesc('retail_price');
            }
        }

        return view('novinki', compact('products'));
    }

    /**
     * Карточка товара
     * Поиск по slug модель \App\Models\Category метод getRouteKeyName()
     * Поиск по slug модель \App\Models\Product метод getRouteKeyName()
     * 
     * @param  \App\Models\Category $category
     * @param  \App\Models\Product $product
     * @return \Illuminate\View\View
     */
    public function product(Category $category = null, Product $product = null): View
    {
        // Если есть модели Category и Product и товар из этой категории $product->category_id == $category->id
        if ($category && $product && $product->category_id == $category->id) {

            // Заголовок в 2 цвета
            $product->double_color_title = (new \App\Services\ProductTitle($product->title))->double_color_title();

            // Ограничение количества элементов в коллекции галерея
            $product->galleries->slice(0, 3);

            // Рекомендуемые товары
            $product->recommend_products = Product::where('category_id', $product->category_id) // товары из текущей категории
                                                    ->whereNot('id', $product->id) // исключая текущий товар
                                                    ->inRandomOrder()
                                                    ->limit(4)
                                                    ->get();

            // Модель $category нужна для открытия левого меню 
            return view('product', compact('category', 'product'));
        }

        return abort(404);
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

            return view('create-order', compact('products', 'is_create_order'));
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

        // Получение id города
        $city = json_decode(\Illuminate\Support\Facades\Cookie::get('city'), true);

        $city_id = !$city ? '41' : $city['id'];

        // Создаю новую модель Order и получаю id новой записи
        $order_id = \App\Models\Order::insertGetId([
            'first_name' => $validated['first-name'],
            'last_name' => $validated['last-name'],
            'phone'=> $phone,
            'email'=> $validated['email'],
            'city_id' => $city_id,
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
                            ->orWhere('text_html', 'like', "%{$search_query}%")
                            ->paginate(40)
                            ->onEachSide(1)
                            ->withQueryString();

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

    // test
    public function remove_barcode_from_text_html()
    {
        // $test_str = '<p style="font-style:italic;">Citrullus lanatus (Thumb.) Matsum.&amp; Nakai</p><p><strong>Скороспелый! Сверхурожайный! Устойчивый к пониженным температурам! </strong></p><p>Осторожно! Опасен для здоровья человека! Можно надорвать спину, перенося урожай с огорода в подвал! Плоды вырастают до 18 кг, а среднестатистические – до 9 кг. Скороспелый, сверхурожайный гибрид для выращивания в открытом грунте и под временными плёночными укрытиями. Плоды округло-овальные, ярко-зелёные, с более тёмными полосами. Мякоть ярко-красная, нежная, зернистая, очень сладкая и ароматная.</p><p><strong>Ценность гибрида:</strong> отличные вкусовые качества, устойчивость к пониженным температурам и неблагоприятным условиям выращивания. Плоды сохраняют товарные качества в течение 20-30 дней.</p><p>Посев на рассаду – в начале мая. Высадка рассады в грунт в конце мая – начале июня, в фазе 3-4 настоящих листьев. Схема посадки 100х100 см. В южных регионах можно выращивать путём прямого посева в грунт в апреле – мае. При выращивании под плёночными укрытиями растения формируют в один стебель (удаляют все боковые побеги до высоты 50 см, последующие прищипывают над 1-3 листом), подвязывают к шпалере. Для хорошего роста и обильного плодоношения растениям необходим своевременный полив, регулярная прополка и подкормка минеральными удобрениями.</p>';

        // Получаю все товары
        // $products = \App\Models\Product::all();

        // Удаление штрихкода из описания товара
        // $i = 0;
        // foreach ($products as $product) {
        //     // if ($i == 0) {
        //         if ($product["text_html"]) {
        //             $search = '<p style="font-size:92%;">' . $product["barcode"] . '</p>';
        //             $product->text_html = str_replace($search, '', $product["text_html"]);
        //             $product->save();
        //         }
        //     // }
        //     $i++;
        // }

        // Перемещение строки с латинским название из начала в конец описания

        // Получаю все товары
        /*
        $products = \App\Models\Product::all();

        $i = 0;
        foreach ($products as $product) {
            // if ($product["id"] == 60) {
                if ($product["text_html"]) {
                    $needle = '</p>';
                    $start = 0;
                    $stop = stripos($product["text_html"], $needle) + 4;

                    if (strpos($product["text_html"], '<p style="font-style:italic;">') === 0) {
                        $latin_name = mb_substr($product["text_html"], $start, $stop);

                        $tail = mb_substr($product["text_html"], $stop);
    
                        $product->text_html = $tail . $latin_name;

                        $product->save();
                    }

                }
            // }
            $i++;
        }
        */


        // Вставка новой категории Ягоды после Цветы

        // Получаю все категории
        /*
        $categories = \Illuminate\Support\Facades\DB::table('categories')->get();
        // $categories02 = \App\Models\Category::where('id', '<', 3)->get();

        $categories = $categories->toArray();

        $newcat = [];
        foreach($categories as $cat) {
            $newcat[] = (array)$cat;
        }

        $first_array = array_merge(
            array_slice( $newcat, 0, 2 ),
            [
                [
                    "id" => 3,
                    "parent" => 0,
                    "title" => "Ягоды",
                    "slug" => "yagody",
                    "image" => "public/uploads/categories/ovoshchi.jpg",
                    "count_children" => 0,
                    "sort" => 0,
                    "created_at" => "2024-10-21 19:22:32",
                    "updated_at" => "2024-10-21 19:22:32",
                ]
            ],
            
        );

        $tail_array = array_slice( $newcat, 2 );

        $new_tail_array = [];
        foreach($tail_array as $value) {
            $item["id"] = $value["id"] + 1;
            $item["parent"] = $value["parent"];
            $item["title"] = $value["title"];
            $item["slug"] = $value["slug"];
            $item["image"] = $value["image"];
            $item["count_children"] = $value["count_children"];
            $item["sort"] = $value["sort"];
            $item["created_at"] = $value["created_at"];
            $item["updated_at"] = $value["updated_at"];

            $new_tail_array[] = $item;
        }
        // $tail_array[0]["id"] = 1;

        // $sliced1 = $categories->slice(2, 0);

        // $model = new \App\Models\Category();

        // $model->parent = 0;
        // $model->title = "Цветы";
        // $model->image = "public/uploads/categories/ovoshchi.jpg";
        // $model->count_children = 0;
        // $model->sort = 0;

        // $categories02->merge($model);

        // \App\Models\Category::truncate();

        // dd(\App\Models\Category::insert($insert_array));

        $insert_array = array_merge(
            $first_array,
            $new_tail_array
        );

        // dd($insert_array);

        \App\Models\Category::truncate();

        dd(\App\Models\Category::insert($insert_array));
        */

        // Обновление parent для дочерних категорий > 3 + 1

        /*
        $categories = \App\Models\Category::all();

        foreach($categories as $cat) {
            if ($cat->parent >= 3) {
                $cat->parent = $cat->parent + 1;
                $cat->save();
            }
        }
        */

        // Обновление category_id для товаров > 3 + 1
        /*
        $products = \App\Models\Product::all();

        foreach($products as $product) {
            if ($product->category_id >= 3) {
                $product->category_id = $product->category_id + 1;
                $product->save();
            }
        }
        */


        // Удаление <p style="font-size:92%;">4656758757527</p> из описания товара. Таблица products, поле text_html
        /*
        $products = \App\Models\Product::all();

        $i = 0;
        foreach ($products as $product) {
            // if ($product["id"] == 55) {
                // Проверка на наличие текста в поле text_html
                if ($product["text_html"]) {

                    // Поиск 13 цифр по регулярному выражению
                    preg_match('/\d{13}/', $product->text_html, $found);
                    
                    // Проверка на массива $found на пустоту
                    if ($found) {
                        // Строка для замены
                        $search = '<p style="font-size:92%;">' . $found[0] . '</p>';

                        // Замена текста
                        $product->text_html = str_replace($search, '', $product["text_html"]);

                        // Обновление модели
                        $product->save();
                    }
                }
            // }
            $i++;
        }
        */


        // Добавить каждому 30му товару промоскидку поле promo_price = 1.75 * wholesale_price
        $products = \App\Models\Product::all();

        $i = 0;
        foreach ($products as $product) {
            // if ($product["id"] == 1) {
                if ($i % 30 === 0) {
                    $product->promo_price = $product->wholesale_price * 1.75;
                    $product->save();
                }

            // }
            $i++;
        }


        // Убрать (УД) Е/П (ВХ) (ШТВ)
        $products = \App\Models\Product::all();
        $i = 0;
        foreach ($products as $product) {
            // if ($product["id"] == 1) {
                if ($product["text_html"]) {
                    // $product->title = str_replace('(УД)', '', $product["title"]);
                    // $product->title = str_replace('Е/П', '', $product["title"]);
                    // $product->title = str_replace('(ВХ)', '', $product["title"]);
                    // $product->title = str_replace('(ШТВ)', '', $product["title"]);
                    // $product->title = str_replace('Б/Ф', '', $product["title"]);
                    // $product->title = str_replace('(Скидка не предоставляется)', '', $product["title"]);
                    $product->text_html = str_replace('</strong>', '</b>', $product["text_html"]);
                    
                    
                    $product->save();
                }
            // }
            $i++;
        }
       

        return false;
    }
}
