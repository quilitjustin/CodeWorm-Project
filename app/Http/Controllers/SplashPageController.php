<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplashPage;

class SplashPageController extends Controller
{
    //
    public function index(){
        return view('superadmin.splash_page.index');
    }

    public function show(){
        $content = page_content::select('content')->latest()->first();

        return view('superadmin.splash_page.show', [
            'content' => $content
        ]);
    }
}
