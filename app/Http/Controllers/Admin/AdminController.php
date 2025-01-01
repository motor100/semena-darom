<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\Page;
// use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function home(): View
    {
        return view('dashboard.home');
    }

    public function page_404(): View
    {
        return view('dashboard.404');
    }
}
