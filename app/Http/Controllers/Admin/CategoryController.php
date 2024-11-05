<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
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

        $categories = '';

        if($search_query) {
            $search_query = htmlspecialchars($search_query);
            $categories = Category::where('title', 'like', "%{$search_query}%")->get();

            return view('dashboard.category', compact('categories'));

        } else {
            $categories = Category::where('parent', '0')->orderBy('sort')->get();
            $subcategories = Category::where('parent', '>', '0')->orderBy('sort')->get();

            return view('dashboard.category', compact('categories', 'subcategories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {   
        // Parent categories
        $categories = Category::where('parent', 0)->get();
        
        return view('dashboard.category-create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:200',
            'sort' => 'nullable|numeric',
            'category' => 'nullable',
            'input-main-file' => [
                'required',
                \Illuminate\Validation\Rules\File::types(['jpg', 'png'])
                                                    ->min(1)
                                                    ->max(5 * 1024)
            ],
        ]);

        // Создание slug из названия
        $slug = Str::slug($validated["title"]);

        // Проверка на уникальный slug
        $slug = (new \App\Services\Slug(Category::query(), $slug))->check();

        // Сохранение файла
        $image = array_key_exists("input-main-file", $validated) ? Storage::putFile('public/uploads/categories', $validated["input-main-file"]) : NULL;

        Category::create([
            'title' => $validated["title"],
            'parent' => isset($validated['category']) ? $validated['category'] : 0,
            'slug' => $slug,
            'image' => $image,
            'count_children' => 0,
            'sort' => $validated["sort"] ? $validated["sort"] : 0
        ]);

        return redirect('/admin/category');
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
        $category = Category::findOrFail($id);

        $pr_categories = Category::where('parent', '0')
                                        ->whereNot('id', $category->id) // исключая текущую категорию
                                        ->get();

        return view('dashboard.category-edit', compact('category', 'pr_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:200',
            'category' => 'nullable',
            'sort' => 'required|numeric',
            'input-main-file' => [
                                'nullable',
                                \Illuminate\Validation\Rules\File::types(['jpg', 'png'])
                                                                    ->min(10)
                                                                    ->max(3000)
            ]
        ]);

        $ct = Category::findOrFail($id);

        if (isset($validated['input-main-file'])) {
            if (Storage::exists($ct->image)) {
                Storage::delete($ct->image);
            }
            $path = Storage::putFile('public/uploads/categories', $request->file('input-main-file'));
        } else {
            $path = $ct->image;
        }

        $slug = Str::slug($validated["title"]);

        if($slug != $ct->slug) {
            // Проверка на уникальный slug
            $slug = (new \App\Services\Slug(Category::query(), $slug))->check();
        }

        $ct->update([
            'parent' => isset($validated['category']) ? $validated['category'] : 0,
            'title' => $validated["title"],
            'slug' => $slug,
            'image' => $path,
            'count_children' => 0,
            'sort' => $validated["sort"]
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function destroy($id): RedirectResponse
    {
        $category = Category::findOrFail($id);
        
        $products = \App\Models\Product::where('category_id', $category->id)->get();

        // Удаление только категории без товаров
        if ($products->count() == 0) {
            // Удаление файла category image
            if (Storage::disk('public')->exists('/uploads/categories/' . $category->image)) {
                Storage::disk('public')->delete('/uploads/categories/' . $category->image);
            }

            // Удаление модели Category
            $category->delete();
        }

        return redirect()->back();
    }
}
