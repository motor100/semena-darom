<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainSlider;
use Illuminate\Support\Facades\Storage;

class MainSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = MainSlider::all();

        return view('dashboard.main-slider', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.main-slider-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:4|max:255',
            'text' => 'required|min:4|max:255',
            'input-main-file' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $path = Storage::putFile('public/uploads/main-slider', $validated["input-main-file"]);

        MainSlider::create([
            'title' => $validated["title"],
            'text' => $validated["text"],
            'image' => $path
        ]);

        return redirect('/dashboard/main-slider');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slide = MainSlider::findOrFail($id);

        return view('dashboard.main-slider-show', compact('slide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slide = MainSlider::findOrFail($id);

        return view('dashboard.main-slider-edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|numeric',
            'title' => 'required|min:4|max:255',
            'text' => 'required|min:4|max:255',
        ]);

        $slide = MainSlider::findOrFail($validated["id"]);

        if ($request->has('input-main-file')) {
            if (Storage::exists($slide->image)) {
                Storage::delete($slide->image);
            }
            $path = Storage::putFile('public/uploads/main-slider', $request->file('input-main-file'));
        } else {
            $path = $slide->image;
        }

        $slide->update([
                'title' => $validated["title"],
                'text' => $validated["text"],
                'image' => $path,
        ]);

        return redirect('/dashboard/main-slider');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slide = MainSlider::find($id);

        // Удаление файла
        if (Storage::exists($slide->image)) {
            Storage::delete($slide->image);
        }

        $slide->delete();

        return redirect('/dashboard/main-slider');
    }
}
