<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;

class LoginValidationController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->intended('dashboard');
        }
        return view('auth.login');
    }

    public function validate_user(LoginRequest $request){
        $credentials = $request->validated();

        if(Auth::attempt($credentials)){
            return redirect()->intended('dashboard')->with('msg', 'Created Successfully');
        }
        return redirect()->route('login')->withErrors(['Invalid Credentials']);
    }   

    public function profile(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        return view('auth.profile');
    }

    protected function capitalize($data){
        return ucwords(strtolower($data));
    }

    public function profile_update(UpdateUserRequest $request, User $user){
        //
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $data = $request->validated();
        
        if($data['action'] == 'password'){
            $user->password = Hash::make($data['password']);
        }
        if($data['action'] == 'details'){
            $user->f_name = $this->capitalize($data['f-name']);
            $user->l_name = $this->capitalize($data['l-name']);
            $user->m_name = $this->capitalize($data['m-name']);
            $user->email = $data['email'];
        }
        
        $user->save();

        return redirect()->route('profile')->with('msg', 'Updated Successfully');
    }

    public function logout(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        Session::flush();
        Auth::logout();

        return redirect("/");
    }
}
