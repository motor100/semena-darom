<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    /**
     * Ajax product search
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\JsonResponse
     */
    public function ajax_product_search(Request $request): JsonResponse
    {
        $search_query = $request->input('search_query');

        if (!$search_query) {
            return response()->json([]);
        }

        $search_query = htmlspecialchars($search_query);

        $products = Product::where('title', 'like', "%{$search_query}%")
                            ->select('title', 'slug')
                            // если нужен поиск по тексту
                            ->orWhere('text_html', 'like', "%{$search_query}%") 
                            ->get();

        return response()->json($products);
    }

    public function ajax_add_to_cart(Request $request): JsonResponse
    {
        $id = $request->input('id');

        $cart = [];
        
        // Если есть в куки cart, то добавляю в конец массива
        if ($request->hasCookie('cart')) {

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

    public function ajax_plus_cart(Request $request): bool
    {   
        $id = $request->input('id');

        // Получение куки через фасад Cookie метод get
        $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

        $cart[$id] = $cart[$id] + 1;

        $cart_json = json_encode($cart);

        // Установка куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('cart', $cart_json, 525600);

        return false;
    }

    public function ajax_minus_cart(Request $request): bool
    {   
        $id = $request->input('id');

        // Получение куки через фасад Cookie метод get
        $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

        $cart[$id] = $cart[$id] - 1;
        
        if ($cart[$id] > 1) {

            $cart_json = json_encode($cart);
            
            // Установка куки через фасад Cookie метод queue
            \Illuminate\Support\Facades\Cookie::queue('cart', $cart_json, 525600);
        }

        return false;
    }

    public function ajax_add_to_favourites(Request $request): int
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

    public function ajax_testimonial(Request $request): JsonResponse
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
        $g_response = (new \App\Services\GoogleCaptcha($validated))->get();

        if (!$g_response) {
            return response()->json(['message' => 'error']);
        }

        /**
         * Если есть файл
         * Автоматически генерировать уникальный идентификатор для имени файла
         * Иначе NULL
         */
        $path = array_key_exists("file", $validated) ? \Illuminate\Support\Facades\Storage::putFile('public/uploads/testimonials', $validated["file"]) : NULL;

        $testimonial = Testimonial::create([
                    'name' => $validated["name"],
                    'email' => $validated["email"],
                    'text' => $validated["text"],
                    'image' => $path,
                    'publicated_at' => NULL
                ]);

        return response()->json($testimonial);
    }

    public function ajax_we_use_cookie(): bool
    {
        // Записываю в куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('we-use-cookie', 'yes', 525600);

        return false;
    }

    public function ajax_city_select(Request $request): JsonResponse
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

    public function ajax_city(Request $request): JsonResponse
    {
        $city = $request->input('city');

        // Записываю новый массив в куки через фасад Cookie метод queue
        \Illuminate\Support\Facades\Cookie::queue('city', $city, 525600);

        return response()->json(['message' => 'error']);
    }

    public function ajax_ordercheck(Request $request): mixed
    {   
        $validated = $request->validate([
            'order_id' => 'required|numeric|min:0',
            'search_query' => 'required|numeric|min:0',
        ]);

        $products = \App\Models\OrderProduct::where('order_id', $validated['order_id'])->get();

        $product = Product::where('barcode', $validated['search_query'])->first();

        if (!$product) {
            return response()->json([
                "no_product" => true,
            ]);
        }

        $no_order = false;
        foreach($products as $value) {
            if ($value->product_id == $product->id) {
                $no_order = true;
            }
        }

        if (!$no_order) {
            return response()->json([
                "no_in_order" => true,
            ]);
        }

        return response()->json($product);

    }
}