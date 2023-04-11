<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PublicProfileController extends Controller
{
    //
    public function index(){
        return view('web.profile.index');
    }

    public function show($user)
    {
        $user = User::findorfail($user)->select()->get();

        return view('web.profile.show', [
            'user' => $user
        ]);
    }
}
