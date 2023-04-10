<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;

class LoginValidationController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('super.dashboard');
        }
        return view('superadmin.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            return redirect()
                ->route('super.dashboard')
                ->with('msg', 'Login Successfully');
        }
        return redirect()
            ->route('super.login')
            ->withErrors(['Invalid Credentials']);
    }

    public function profile()
    {
        return view('superadmin.auth.profile');
    }

    protected function capitalize($data)
    {
        return ucwords(strtolower($data));
    }

    public function profile_update(UpdateUserRequest $request, User $user)
    {
        //
        $data = $request->validated();

        if ($data['action'] == 'password') {
            $user->password = Hash::make($data['password']);
        }
        if ($data['action'] == 'details') {
            $user->f_name = $this->capitalize($data['f-name']);
            $user->l_name = $this->capitalize($data['l-name']);
            $user->m_name = $this->capitalize($data['m-name']);
            $user->email = $data['email'];
        }

        $user->save();

        return redirect()
            ->route('profile')
            ->with('msg', 'Updated Successfully');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
