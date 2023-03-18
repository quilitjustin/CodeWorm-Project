<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PublicProfileController extends Controller
{
    //
    public function index(){
        return view('public.profile.index');
    }

    public function show(User $user){
        return view('public.profile.show', [
            'user' => $user
        ]);
    }
}
