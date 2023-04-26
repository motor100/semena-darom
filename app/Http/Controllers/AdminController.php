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
