<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   
        // Шаблон главной страницы
        view()->composer('*', function ($view) // прикрепить компоновщик ко всем шаблонам
        {
            // Categories
            // Get all categories
            $categories = \App\Models\Category::all();

            // Get parent categories
            $parent_categories = $categories->where('parent', '0')->sortBy('sort');

            // Get child categories
            foreach($parent_categories as $pct) {
                $child_category = $categories->where('parent', $pct->id)->sortBy('title'); // сортировка по названию
                // $child_category = $categories->where('parent', $pct->id)->sortBy('sort'); // сортировка по полю sort
                if ($child_category->count() > 0) {
                    $pct->child_category = $child_category;
                }
            }

            $view->with('parent_categories', $parent_categories);
            
            // City
            $city = json_decode(\Illuminate\Support\Facades\Cookie::get('city'), true);

            if ($city) {
                $city_name = $city['title'];
            } else {
                $city_name = (new \App\Services\City())->get_city_from_ip();

                // Записываю новый массив в куки через фасад Cookie метод queue
                // \Illuminate\Support\Facades\Cookie::queue('city', $city, 525600);

                $city = \App\Models\City::where('title', $city_name)
                                            ->where('search', '1')
                                            ->first();

                $city_array = [
                    'id' => $city["id"],
                    'title' => $city["title"]
                ];
    
                $city_json = json_encode($city_array);
    
                // Установка куки через фасад Cookie метод queue
                \Illuminate\Support\Facades\Cookie::queue('city', $city_json, 525600);
            }

            $view->with('city_name', $city_name);

            // Count products in cart
            $cart = json_decode(\Illuminate\Support\Facades\Cookie::get('cart'), true);

            if ($cart) {
                $cart_count = count($cart);
                $cart_count = $cart_count > 9 ? 9 : $cart_count;
                $view->with('cart_count', $cart_count);
            }

            // Products in cart
            if ($cart) {
                $keys = array_keys($cart);
                $products_in_cart = \App\Models\Product::whereIn('id', $keys)->get();
                foreach ($products_in_cart as $product) {
                    $product->quantity = $cart[$product->id];
                }
                $view->with('products_in_cart', $products_in_cart);
            }

            // Count products in favourites
            $favourites = json_decode(\Illuminate\Support\Facades\Cookie::get('favourites'), true);

            if ($favourites) {
                $favourites_count = count($favourites);
                $favourites_count = $favourites_count > 9 ? 9 : $favourites_count;
                $view->with('favourites_count', $favourites_count);
            }

        });

        // Шаблон панели администратора
        view()->composer('dashboard.layout', function ($view)
        {
            // New testimonials
            $testimonials_count = \App\Models\Testimonial::whereNull('publicated_at')
                                                        ->count();

            $view->with('testimonials_count', $testimonials_count);

            // New orders
            $orders_count = \App\Models\Order::where('status', 'В обработке')->count();

            $view->with('orders_count', $orders_count);
        });

        // Шаблон личный кабинет
        /*
        view()->composer('profile.layout', function ($view)
        {
            // User
            $user = Auth::user();

            // Если пользователя есть, то 
            if ($user) {
                $office = \App\Models\Office::where('user_id', $user->id)->first();

                $view->with('office', $office);
            }
        });
        */
    }
}
