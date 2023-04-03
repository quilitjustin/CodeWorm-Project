<?php

namespace App\Http\Controllers\Web;

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
            return redirect()->intended();
        }
        return view('web.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            return redirect()
                ->intended();
        }
        return redirect()
            ->route('web.login')
            ->withErrors(['Invalid Credentials']);
    }

    public function profile()
    {
        return view('web.auth.profile');
    }

    protected function capitalize($data)
    {
        return ucwords(strtolower($data));
    }

    public function profile_update(UpdateUserRequest $request, User $user)
    {
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
            ->route('web.profile')
            ->with('msg', 'Updated Successfully');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
