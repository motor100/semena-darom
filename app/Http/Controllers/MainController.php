<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function home()
    {   
        // Products
        $products = Product::limit(4)->get();

        $products->each(function ($item, $key) {
            $item->short_title = Str::limit($item->title, 38, '...');
            $item->short_text = Str::limit($item->text, 60, '...');
        });

        // Categories
        // Get all categories
        $categories = \App\Models\Category::all();

        // Get parent categories
        $parent_category = $categories->where('parent', '0');

        // Get child categories
        foreach($parent_category as $pct) {
            $child_category = $categories->where('parent', $pct->id);
            if ($child_category->count() > 0) {
                $pct->child_category = $child_category;
            }
        }

        // dd($parent_category);
        
        return view('home', compact('products', 'parent_category'));
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