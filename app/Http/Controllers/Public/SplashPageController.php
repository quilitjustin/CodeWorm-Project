<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplashPage;

class SplashPageController extends Controller
{
    //
    public function index()
    {
        // Will return the latest version
        $content = SplashPage::latest()->first()->get();

        return view('public.index', [
            "content" => $content
        ]);
    }
}
