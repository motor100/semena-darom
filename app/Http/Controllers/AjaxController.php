<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Testimonial;


class AjaxController extends Controller
{
    public function ajax_product_search(Request $request)
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
        if (!$request->has('city')) {
            return response()->json(['message' => 'error']);
        }

        $city = $request->input('city');
        $cities = collect();

        if (strlen($city) >= 3 && strlen($city) < 40) {

            $city = htmlspecialchars($city);

            $cities = \App\Models\City::where('city', 'like', "%{$city}%")->get();
        }

        return response()->json($cities);
    }

    public function ajax_add_to_cart(Request $request)
    {
        $id = $request->input('id');

        $cart = [];
        
        if ($request->hasCookie('cart')) { // Если есть в куки cart, то добавляю в конец массива

            // Получение куки через фасад Cookie метод get
            $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

            // Если в массиве есть ключ с таким id, то прибавляю количество на 1
            if (array_key_exists($id, $cart)) {
                $cart[$id] = $cart[$id] + 1;
            } else {
                $cart[$id] = 1;
            }

        } else {
            $cart[$id] = 1;
        }

        $cart_json = json_encode($cart);

        // Установка куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('cart', $cart_json, 525600);

        // Все что ниже нужно для показа товаров в корзине справа >1400px
        $keys = array_keys($cart);

        // Получение моделей товаров
        $products = Product::whereIn('id', $keys)->get();

        // Добавляю количество к каждому товару
        foreach ($products as $product) {
            $product->quantity = $cart[$product->id];
        }

        return response()->json($products);
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

        $favourites_count = 0;
        $favourites = [];
        
        if ($request->hasCookie('favourites')) { // Если есть в куки favourites, то добавляю в конец массива

            // Получение куки через фасад Cookie метод get
            $favourites = json_decode(\Illuminate\Support\Facades\Cookie::get('favourites'), true);

            // Если в массиве есть ключ с таким id, то прибавляю количество на 1
            if (array_key_exists($id, $favourites)) {
                $favourites[$id] = $favourites[$id] + 1;
            } else {
                $favourites[$id] = 1;
            }
            $favourites_count = count($favourites);

        } else {
            $favourites_count = 1;
            $favourites[$id] = 1;
        }

        $favourites_count = $favourites_count > 9 ? 9 : $favourites_count;

        $favourites_json = json_encode($favourites);

        // Установка куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('favourites', $favourites_json, 525600);
        
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
        // Записываю в куки через response with coockie
        // return response()
        //         ->json(['Cookie set successfully'])
        //         ->withCookie(cookie('we-used-cookie', 'yes', 525600));

        // Записываю в куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('we-used-cookie', 'yes', 525600);

        return false;
    }

    public function ajax_city(Request $request)
    {
        $city = $request->input('city');

        // Записываю новый массив в куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('city', $city, 525600);
        return response()->json(['message' => 'error']);
        return false;
    }
}
