<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promos = Promo::orderBy('id', 'desc')->get();

        return view('dashboard.promo', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.promo-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:4|max:255',
            'discount' => 'required|numeric|min:1|max:100',
            'input-main-file' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $path = Storage::putFile('public/uploads/promos', $validated["input-main-file"]);

        Promo::create([
            'title' => $validated["title"],
            'discount' => $validated["discount"],
            'image' => $path
        ]);

        return redirect('/dashboard/promos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $promo = Promo::findOrFail($id);

        return view('dashboard.promo-show', compact('promo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promo = Promo::findOrFail($id);

        return view('dashboard.promo-edit', compact('promo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|min:4|max:255',
            'discount' => 'required|numeric|min:1|max:100',
        ]);

        $promo = Promo::findOrFail($id);

        if ($request->has('input-main-file')) {
            if (Storage::exists($promo->image)) {
                Storage::delete($promo->image);
            }
            
            $path = Storage::putFile('public/uploads/promos', $request->file('input-main-file'));
        } else {
            $path = $promo->image;
        }

        $promo->update([
                'title' => $validated["title"],
                'discount' => $validated["discount"],
                'image' => $path,
        ]);

        return redirect('/dashboard/promos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promo = Promo::findOrFail($id);

        // Удаление файла
        if (Storage::exists($promo->image)) {
            Storage::delete($promo->image);
        }

        $promo->delete();

        return redirect('/dashboard/promos');
    }
}
