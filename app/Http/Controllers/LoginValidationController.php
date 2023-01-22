<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginValidationController extends Controller
{
    public function validate_user(LoginRequest $request){
        $credentials = $request->validated();

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard')->with('msg', 'Created Successfully');
        }
        return redirect()->route('login')->withErrors(['Invalid Credentials']);
    }   

    public function logout(){
        Session::flush();
        Auth::logout();

        dd(Auth::user());
    }
}
