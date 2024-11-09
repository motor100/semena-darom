<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RussianPostController extends Controller
{
    public function test()
    {
        return (new \App\Services\RussianPost())->test();
    }

    public function test_test(Request $request)
    {
        return Storage::disk('public')->append('uploads/file/rr.txt', $request);
    }

    public function create_order()
    {
        return;
    }
}