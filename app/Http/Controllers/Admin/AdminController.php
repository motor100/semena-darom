<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function home(): View
    {
        return view('dashboard.home');
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj(): View
    {
        $page = \App\Models\Page::where('id', 1)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function polzovatelskoe_soglashenie_s_publichnoj_ofertoj_update(Request $request): RedirectResponse
    {
        $page = Page::where('id', 1)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function politika_konfidencialnosti(): View
    {
        $page = \App\Models\Page::where('id', 2)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function politika_konfidencialnosti_update(Request $request): RedirectResponse
    {
        $page = Page::where('id', 2)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function garantiya_vozvrata_denezhnyh_sredstv(): View
    {
        $page = \App\Models\Page::where('id', 3)->first();

        return view('dashboard.text-page', compact('page'));
    }

    public function garantiya_vozvrata_denezhnyh_sredstv_update(Request $request): RedirectResponse
    {
        $page = Page::where('id', 3)
                    ->update([
                        'text' => $request->input('text')
                    ]);

        return redirect('/dashboard/politika-konfidencialnosti');
    }

    public function page_404(Request $request): View
    {
        return view('dashboard.404');
    }
}
