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
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {   
        $search_query = $request->input('search_query');

        $products = '';

        if($search_query) {
            $search_query = htmlspecialchars($search_query);
            $products = Product::where('title', 'like', "%{$search_query}%") // поиск по заголовку
                                ->orWhere('barcode', $search_query) // поиск по штрихкоду
                                ->paginate();
        } else {
            $products = Product::orderBy('id', 'desc')
                                ->paginate(50)
                                ->onEachSide(1);
        }
        
        return view('dashboard.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
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
            'text_json' => 'required|min:2|max:65535',
            'input-main-file' => 'nullable|image|mimes:jpg,png,jpeg',
            'barcode' => 'required|min:8|max:15|unique:App\Models\Product,barcode',
            'stock' => 'nullable|min:0|max:10000',
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

        $img = NULL;

        if (isset($validated['input-main-file'])) {
            $img = (new \App\Services\File())->rename_file($slug, $validated['input-main-file'], $folder);
        }

        $html = (new \App\Services\JsonToHtml($validated['text_json']))->render();

        // Массив для вставки в модель \App\Models\Product и во внешнюю БД таблица products
        $product_array = [
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $validated['category'],
            'image' => $img,
            'text_json' => $validated['text_json'],
            'text_html' => $html,
            'barcode' => $validated['barcode'],
            'stock' => $validated['stock'] ? $validated['stock'] : 0, // количество на складе по умолчанию 0
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
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {   
        $product = Product::findOrFail($id);

        // $category = \App\Models\Category::where('count_children', 0)->get();
        $category = \App\Models\Category::all();

        $current_category = $category->where('id', $product->category_id)->first();

        // Передача данных в редактор Editor JS
        $to_editorjs = $product->text_json;

        return view('dashboard.products-edit', compact('product', 'category', 'current_category', 'to_editorjs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|min:2|max:250',
            'category' => 'required',
            'text_json' => 'required|min:2|max:65535',
            'input-main-file' => [
                                'nullable',
                                \Illuminate\Validation\Rules\File::types(['jpg', 'png'])
                                                                    ->min(10)
                                                                    ->max(3000)
                                ],
            'input-gallery-file' => 'nullable|max:4',
            'input-gallery-file.*' => [
                                \Illuminate\Validation\Rules\File::types(['jpg', 'png'])
                                                                    ->min(10)
                                                                    ->max(3000)
                                ],
            'barcode' => [
                'required',
                'min:10',
                'max:16',
                Rule::unique('products')->ignore($id)
            ],
            'stock' => 'nullable|min:0|max:10000',
            'buying_price' => 'required|min:0',
            'wholesale_price' => 'required|min:0',
            'retail_price' => 'required|min:0',
            'weight' => 'required|min:1',
            'position' => 'required|min:1|max:1000000',
            'gallery' => 'nullable',
            'promo_price' => 'nullable',
            'brand'  => 'nullable',
            'property' => 'nullable',
            'delete_gallery' => 'nullable',
        ]);

        $product = Product::findOrFail($id);

        $slug = Str::slug($validated['title']);

        if($slug != $product->slug) {
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

        $html = (new \App\Services\JsonToHtml($validated['text_json']))->render();

        $folder = 'products';

        if (isset($validated['input_main_file'])) {
            if (Storage::disk('public')->exists('/uploads/products/' . $product->image)) {
                Storage::disk('public')->delete('/uploads/products/' . $product->image);
            }
            $img = (new \App\Services\File())->rename_file($slug, $validated['input_main_file'], $folder);
        } else {
            $img = $product->image;
        }

        if ($validated['delete_gallery']) {
            // Удаление файлов gallery images 
            foreach($product->galleries as $gl) {
                if (Storage::disk('public')->exists('/uploads/products/' . $gl->image)) {
                    Storage::disk('public')->delete('/uploads/products/' . $gl->image);
                }
                $gl->delete();
            }
        }

        if(isset($validated['input-gallery-file'])) {
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

            // Вставка новых записей галереи
            $gallery_array = [];

            $gallery = $validated['input-gallery-file'];

            foreach($gallery as $gl) {
                $gallery_item = [];
                $gallery_item["product_id"] = $id;
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
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $validated['category'],
            'image' => $img,
            'text_json' => $validated['text_json'],
            'text_html' => $html,
            'barcode' => $validated['barcode'],
            'stock' => $validated['stock'] ? $validated['stock'] : 0,
            'buying_price' => $validated['buying_price'] ? str_replace(',', '.', $validated['buying_price']) : NULL,
            'wholesale_price' => str_replace(',', '.', $validated['wholesale_price']),
            'retail_price' => str_replace(',', '.', $validated['retail_price']),
            'promo_price' => $validated['promo_price'] ? str_replace(',', '.', $validated['promo_price']) : NULL,
            'weight' => $validated['weight'],
            'brand' => $validated['brand'],
            'property' => $validated['property'],
            'position' => $validated['position'],
            'updated_at' => now()
        ];

        $product->update($product_array);

        // Обновление во внешней БД таблица products
        DB::connection('mysql2')
            ->table('products')
            ->where('id', $product->id)
            ->update($product_array);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $product = Product::findOrFail($id);

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
