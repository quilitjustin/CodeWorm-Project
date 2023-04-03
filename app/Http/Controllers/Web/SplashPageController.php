<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplashPage;

class SplashPageController extends Controller
{
    //
    public function index()
    {
        // Will return the latest version
        // laravel will automatically decode the json by default so there's no need to decode here nor in blade
        $content = SplashPage::select('content')->latest()->first();
        
        return view('web.index', [
            "content" => $content['content']
        ]);
    }
}
