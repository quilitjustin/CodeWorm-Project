<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicProfileController extends Controller
{
    //
    public function index(User $user){
        return view('public.profile', [
            'user' => $user
        ]);
    }
}
