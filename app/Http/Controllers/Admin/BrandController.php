<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {   
        $validated = $request->validate([
            'search_query' => 'nullable|alpha_dash|min:3|max:50',
        ]);

        $brands = '';

        if(isset($validated['search_query'])) {
            $brands = Brand::where('title', 'like', "%{$validated['search_query']}%") // поиск по заголовку
                                ->paginate();
        } else {
            $brands = Brand::orderBy('id', 'desc')
                                ->paginate(50)
                                ->onEachSide(1);
        }
        
        return view('dashboard.brands', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {   
        return view('dashboard.brands-create');
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
        ]);

        $slug = Str::slug($validated['title']);

        // Проверка на уникальный slug
        $slug = (new \App\Services\Slug(Brand::query(), $slug))->check();

        // Массив для вставки в модель \App\Models\Brand и во внешнюю БД таблица brands
        $brand_array = [
            'title' => $validated['title'],
            'slug' => $slug,
            'created_at' => now(),
            'updated_at' => now()
        ];

        $brand = new Brand($brand_array);

        $brand->save();

        // Вставка записи во внешнюю БД таблица brands
        DB::connection('mysql2')
            ->table('brands')
            ->insert($brand_array);

        return redirect()->route('admin.brands');
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
        $brand = Brand::findOrFail($id);

        return view('dashboard.brands-edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:50',
        ]);
        
        $brand = Brand::findOrFail($id);
        
        $slug = Str::slug($validated['title']);
 
        // Проверка на уникальный slug
        $slug = (new \App\Services\Slug(Brand::query(), $slug))->check();
        
        $brand_array = [
            'title' => $validated['title'],
            'slug' => $slug,
            'updated_at' => now()
        ];

        $brand->update($brand_array);

        // Обновление записи внешней БД таблица brands
        DB::connection('mysql2')
            ->table('brands')
            ->where('id', $brand->id)
            ->update($brand_array);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);

        // Удаление модели Brand
        $brand->delete();

        // Удаление записи внешней БД таблица brands
        DB::connection('mysql2')
            ->table('brands')
            ->where('id', $id)
            ->delete();

        return redirect()->back();
    }
}
