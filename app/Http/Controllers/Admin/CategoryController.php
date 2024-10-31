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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('dashboard.category-create');
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
            'parent' => 'nullable',
            'sort' => 'required|numeric',
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

        $parent = 0;

        if (array_key_exists("parent", $validated)) {
            $cat = Category::where('id', $validated["parent"])->first();
            $cat->update([
                'count_children' => $cat->count_children + 1,
            ]);
            $parent = $validated["parent"];
        }

        Category::create([
            'title' => $validated["title"],
            'parent' => $parent,
            'slug' => $slug,
            'image' => $image,
            'count_children' => 0,
            'sort' => $validated["sort"]
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $category = Category::findOrFail($id);

        $parent_ct = Category::where('parent', '0')->get();

        $current_ct = $parent_ct->where('id', $category->parent)->first();

        return view('dashboard.category-edit', compact('category', 'parent_ct', 'current_ct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
            'title' => 'required|min:3|max:200',
            'parent' => 'required',
            'sort' => 'required|numeric',
        ]);

        $ct = Category::find($validated["id"]);

        if ($request->has('input-main-file')) {
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

        $parent = 0;

        if ($ct->parent == 0) {
            $parent = $ct->parent;
        } else {

            // $ct->parent текущая
            // $parent новая
            $old_cat = Category::where('id', $ct->parent)->first();
            $old_cat->update([
                'count_children' => $old_cat->count_children - 1,
            ]);

            $new_cat = Category::where('id', $validated["parent"])->first();
            $new_cat->update([
                'count_children' => $new_cat->count_children + 1,
            ]);

            $parent = $validated["parent"];
            // -1 у текущей
            // +1 у новой
        }

        $ct->update([
            'parent' => $parent,
            'title' => $validated["title"],
            'slug' => $slug,
            'image' => $path,
            'count_children' => 0,
            'sort' => $validated["sort"]
        ]);

        return redirect('/admin/category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
