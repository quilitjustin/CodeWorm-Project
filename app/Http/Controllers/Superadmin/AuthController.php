<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\RequestRegistration;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangePasswordMail;
use App\Mail\ChangeEmailMail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ChangeEmailNotification;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('super.dashboard.index');
        }
        return view('superadmin.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        if (Auth::check()) {
            return redirect()->route('super.dashboard');
        }
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

    public function upload_picture()
    {
        return view('superadmin.auth.upload_picture');
    }

    protected function capitalize($data)
    {
        $data = strip_tags($data);
        return ucwords(strtolower($data));
    }

    public function profile_update(Request $request, $user)
    {
        $request->validate([
            'action' => ['required', 'in:name,email,password,picture'],
        ]);
        $id = decrypt($user);
        $user = User::findorfail($id);

        switch ($request['action']) {
            case 'picture':
                $request->validate([
                    'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
                ]);
                // Make sure you delete the file first before deleting the record in db
                // But before that, you need to make sure that the file still exist in the first place
                if (!is_null($user->profile_picture) && file_exists($user->profile_picture)) {
                    unlink($user->profile_picture);
                }
                // To avoid having a file with the same name
                $newImageName = time() . '-' . $user->f_name . $user->l_name . '.' . $request['image']->extension();
                // Where to store the image
                $path = 'profile/picture';
                // Store the image in public directory
                $request['image']->move(public_path($path), $newImageName);
                // Output would be like: game/BackgroundImage/image.png
                // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
                $user->profile_picture = $path . '/' . $newImageName;
                break;
            case 'name':
                $request->validate([
                    'f_name' => ['required'],
                    'l_name' => ['required'],
                ]);
                $user->f_name = $this->capitalize($request['f_name']);
                if(!is_null($request['m_name'])){
                    $user->m_name = $this->capitalize($request['m_name']);
                }
                $user->l_name = $this->capitalize($request['l_name']);
                break;
            case 'email':
                $request->validate([
                    'email' => [
                        'required',
                        'email',
                        'unique:users',
                        'max:255',
                        function ($attribute, $value, $fail) {
                            if (!strpos($value, '.')) {
                                $fail('The email must have a valid top-level domain.');
                            }
                        },
                    ],
                ]);
                $id = $user->id;
                $email = $request['email'];
                Mail::to($email)->send(new ChangeEmailMail($id, $email));
                // Notification::send($notifiable, new ChangeEmailNotification($request['email']));
                break;
            case 'password':
                $request->validate([
                    'old_password' => [
                        'required',
                        function ($attribute, $value, $fail) use ($request) {
                            if (!Hash::check($request['old_password'], Auth::user()->password)) {
                                $fail('The old password does not match.');
                            }
                        },
                    ],
                    'password' => ['required', 'confirmed', 'min:8'],
                    'password_confirmation' => ['required'],
                ]);
                Mail::to($user->email)->send(new ChangePasswordMail($user->l_name));
                break;
        }

        $user->save();

        if ($request['action'] == 'email') {
            return response()->json(['msg' => 'Verification link has been send to your new email!']);
        }
        if (request()->ajax()) {
            return response()->json(['msg' => 'Updated Successfully']);
        }
        return redirect()
            ->route('super.profile')
            ->with(['msg' => 'Updated Successfully']);
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('super.login');
        }
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('super.login');
    }
}
