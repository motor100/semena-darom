<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AdminController extends Controller
{
    public function home()
    {
        return view('dashboard.home');
    }

    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::whereNull('publicated_at')
                                        ->orderBy('created_at', 'desc')
                                        // ->limit(20)
                                        ->get();

        return view('dashboard.testimonials', compact('testimonials'));
    }

    public function testimonials_update(Request $request)
    {   
        $validated = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|min:3|max:150',
            'text' => 'required|min:3|max:1000',
        ]);

        $testimonial = \App\Models\Testimonial::findOrFail($validated["id"]);

        $testimonial->update([
                        'name' => $validated["name"],
                        'text' => $validated["text"],
                        'publicated_at' => now(),
                    ]);

        return redirect('/dashboard/testimonials');
    }

    public function testimonials_destroy(Request $request)
    {   
        $id = $request->input('id');

        $testimonial = \App\Models\Testimonial::find($id);

        // Удаление файла
        if ($testimonial->image) {
            if (\Illuminate\Support\Facades\Storage::exists($testimonial->image)) {
                \Illuminate\Support\Facades\Storage::delete($testimonial->image);
            }
        }

        $testimonial->delete();

        return redirect('/dashboard/testimonials');
    }




    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj()
    {
        $page = \App\Models\Page::where('id', 1)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj_update(Request $request)
    {
        $page = Page::where('id', 1)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function politika_konfidencialnosti()
    {
        $page = \App\Models\Page::where('id', 2)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function politika_konfidencialnosti_update(Request $request)
    {
        $page = Page::where('id', 2)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function garantiya_vozvrata_denezhnyh_sredstv()
    {
        $page = \App\Models\Page::where('id', 3)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function garantiya_vozvrata_denezhnyh_sredstv_update(Request $request)
    {
        $page = Page::where('id', 3)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }
}
