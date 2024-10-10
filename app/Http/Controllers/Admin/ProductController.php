<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $search_query = $request->input('search_query');

        $products = '';

        if($search_query) {
            $search_query = htmlspecialchars($search_query);
            $products = Product::where('title', 'like', "%{$search_query}%")->get();
        } else {
            $products = Product::orderBy('id', 'desc')->limit(20)->get();
        }
        
        return view('dashboard.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        // $category = \App\Models\Category::where('count_children', 0)->get();
        $category = \App\Models\Category::all();

        return view('dashboard.products-create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {   
        $validated = $request->validate([
            'title' => 'required|min:2|max:250',
            'category' => 'required',
            'text' => 'required|min:2',
            'input-main-file' => 'required|image|mimes:jpg,png,jpeg',
            'code' => 'required|min:10|max:16|unique:App\Models\Product,code',
            'stock' => 'required|min:0|max:10000',
            'buying-price' => 'required|min:0',
            'wholesale-price' => 'required|min:0',
            'retail-price' => 'required|min:0',
            'weight' => 'required|min:1',
            'position' => 'required|min:1|max:1000000',
            'gallery' => 'nullable',
            'promo_price' => 'nullable',
            'brand'  => 'nullable',
            'property' => 'nullable',
        ]);

        $slug = Str::slug($validated['title']);

        // Проверка на уникальный slug
        $have_slug = Product::where('slug', $slug)
                            ->get();
        if (count($have_slug) > 0) {
            $newslug = $slug . '-%';
            $slugs = Product::where('slug', 'like', $newslug)
                            ->get();
            $count_slugs = count($slugs) + 1;
            $slug = $slug . '-' . $count_slugs;
        }

        $promo_price = array_key_exists('promo_price', $validated) ? $validated['promo_price'] : NULL;

        $folder = 'products';

        // $img = \App\Http\Controllers\Admin\AdminController::rename_file($slug, $validated['input-main-file'], $folder);
        $img = (new \App\Services\File())->rename_file($slug, $validated['input-main-file'], $folder);

        // Массив для вставки в модель \App\Models\Product и во внешнюю БД таблица products

        $product_array = [
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $validated['category'],
            'image' => $img,
            'text' => $validated['text'],
            'code' => $validated['code'],
            'stock' => $validated['stock'],
            'buying_price' => $validated['buying-price'] ? str_replace(',', '.', $validated['buying-price']) : NULL,
            'wholesale_price' => str_replace(',', '.', $validated['wholesale-price']),
            'retail_price' => str_replace(',', '.', $validated['retail-price']),
            'promo_price' => $promo_price ? str_replace(',', '.', $validated['promo-price']) : NULL,
            'weight' => $validated['weight'],
            'brand' => $validated['brand'],
            'property' => $validated['property'],
            'position' => $validated['position'],
            'created_at' => now(),
            'updated_at' => now()
        ];

        $product = new Product($product_array);

        $product->save();

        // Галерея
        $id = $product->id;

        if(array_key_exists('gallery', $validated)) {
            $gallery_array = [];
            foreach($validated['gallery'] as $gl) {
                $gallery_item = [];
                $gallery_item["product_id"] = $id;
                // $gallery_item["image"] = \App\Http\Controllers\Admin\AdminController::rename_file($slug, $gl, $folder);
                $gallery_item["image"] = (new \App\Services\File())->rename_file($slug, $gl, $folder);
                $gallery_item["created_at"] = now();
                $gallery_item["updated_at"] = now();
                $gallery_array[] = $gallery_item;
            }

            Gallery::insert($gallery_array);

            // Вставка во внешнюю БД таблица galleries
            DB::connection('mysql2')
                ->table('galleries')
                ->insert($gallery_array);
        }

        // Вставка во внешнюю БД таблица products
        DB::connection('mysql2')
            ->table('products')
            ->insert($product_array);

        return redirect('/admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $product = Product::findOrFail($id);

        // $category = \App\Models\Category::where('count_children', 0)->get();
        $category = \App\Models\Category::all();

        $current_category = $category->where('id', $product->category_id)->first();

        return view('dashboard.products-edit', compact('product', 'category', 'current_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2|max:250',
            'code' => 'required|min:10|max:16',
            'stock' => 'required|min:0|max:10000',
            'buying-price' => 'required|min:0',
            'wholesale-price' => 'required|min:0',
            'retail-price' => 'required|min:0',
            'weight' => 'required|min:1',
            'position' => 'required|min:1|max:1000000',
        ]);

        $id = $request->input('id');

        $pr = Product::find($id);

        $title = $request->input('title');
        $category = $request->input('category');
        $text = $request->input('text');
        $image = $request->file('input-main-file');
        $gallery = $request->file('input-gallery-file');
        $code = $request->input('code');
        $stock = $request->input('stock');
        $code = $request->input('code');
        $buying_price = $request->input('buying-price');
        $wholesale_price = $request->input('wholesale-price');
        $retail_price = $request->input('retail-price');
        $promo_price = $request->input('promo-price');
        $weight = $request->input('weight');
        $brand = $request->input('brand');
        $property = $request->input('property');
        $position = $request->input('position');
        $delete_gallery = $request->input('delete_gallery');

        $slug = Str::slug($title);

        if($slug != $pr->slug) {
            // Проверка на уникальный slug
            $have_slug = Product::where('slug', $slug)
                                ->get();
            if (count($have_slug) > 0) {
                $newslug = $slug . '-%';
                $slugs = Product::where('slug', 'like', $newslug)
                                ->get();
                $count_slugs = count($slugs) + 1;
                $slug = $slug . '-' . $count_slugs;
            }
        }

        if(!$promo_price) {
            $promo_price = NULL;
        }

        $folder = 'products';

        if($image) {
            if (Storage::disk('public')->exists('/uploads/products/' . $pr->image)) {
                Storage::disk('public')->delete('/uploads/products/' . $pr->image);
            }
            // $img = \App\Http\Controllers\Admin\AdminController::rename_file($slug, $image, $folder);
            $img = (new \App\Services\File())->rename_file($slug, $image, $folder);
        } else {
            $img = $pr->image;
        }

        if($delete_gallery) {
            // Удаление файлов gallery images 
            foreach($pr->galleries as $gl) {
                if (Storage::disk('public')->exists('/uploads/products/' . $gl->image)) {
                    Storage::disk('public')->delete('/uploads/products/' . $gl->image);
                }
                $gl->delete();
            }
        }

        if($gallery) {
            $old_gallery = Gallery::where('product_id', $id)->get();
            foreach($old_gallery as $gl) {
                if (Storage::disk('public')->exists('/uploads/products/' . $gl->image)) {
                    Storage::disk('public')->delete('/uploads/products/' . $gl->image);
                }
            }

            Gallery::where('product_id', $id)->delete();

            // Удаление из внешней БД таблица galleries
            DB::connection('mysql2')
                ->table('galleries')
                ->where('product_id', $id)
                ->delete();

            // Новая вставка
            $gallery_array = [];
            foreach($gallery as $gl) {
                $gallery_item = [];
                $gallery_item["product_id"] = $id;
                // $gallery_item["image"] = \App\Http\Controllers\Admin\AdminController::rename_file($slug, $gl, $folder);
                $gallery_item["image"] = (new \App\Services\File())->rename_file($slug, $gl, $folder);
                $gallery_item["created_at"] = now();
                $gallery_item["updated_at"] = now();
                $gallery_array[] = $gallery_item;
            }

            Gallery::insert($gallery_array);

            // Вставка во внешнюю БД таблица galleries
            DB::connection('mysql2')
                ->table('galleries')
                ->insert($gallery_array);
        }

        $product_array = [
            'title' => $title,
            'slug' => $slug,
            'category_id' => $category,
            'image' => $img,
            'text' => $text,
            'code' => $code,
            'stock' => $stock,
            'buying_price' => $buying_price ? str_replace(',', '.', $buying_price) : NULL,
            'wholesale_price' => str_replace(',', '.', $wholesale_price),
            'retail_price' => str_replace(',', '.', $retail_price),
            'promo_price' => $promo_price ? str_replace(',', '.', $promo_price) : NULL,
            'weight' => $weight,
            'brand' => $brand,
            'property' => $property,
            'position' => $position,
            'updated_at' => now()
        ];

        $pr->update($product_array);

        // Обновление во внешней БД таблица products
        // $external_db = config('database.connections.mysql2.database') . '.';

        DB::connection('mysql2')
            ->table('products')
            ->where('id', $pr->id)
            ->update($product_array);

        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        // Удаление файла product image
        if (Storage::disk('public')->exists('/uploads/products/' . $product->image)) {
            Storage::disk('public')->delete('/uploads/products/' . $product->image);
        }

        // Удаление файлов gallery images 
        foreach($product->galleries as $gl) {
            if (Storage::disk('public')->exists('/uploads/products/' . $gl->image)) {
                Storage::disk('public')->delete('/uploads/products/' . $gl->image);
            }
        }

        // Удаление галереи
        Gallery::where('product_id', $id)->delete();

        // Удаление из внешней БД таблица galleries
        DB::connection('mysql2')
            ->table('galleries')
            ->where('product_id', $id)
            ->delete();

        // Удаление из внешней БД таблица products
        DB::connection('mysql2')
            ->table('products')
            ->where('id', $id)
            ->delete();

        // Удаление модели Product
        $product->delete();

        return redirect('/admin/products');
    }
}
