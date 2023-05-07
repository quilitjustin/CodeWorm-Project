<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\RequestRegistration;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('web.announcements.index');
        }
        return view('web.auth.login');
    }

    public function register()
    {
        return view('web.auth.register');
    }

    public function request_registration(Request $request)
    {
        $request->validate([
            'f_name' => ['required'],
            'l_name' => ['required'],
            'email' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
            'school_id' => ['required'],
            'terms' => ['required'],
        ]);

        $email = strip_tags($request['email']);
        $user = User::select('id')->where('email', $email)->first();
        $req_registration = new RequestRegistration;

        if (is_null($user)) {
            $new_user = new User();
            $new_user->f_name = strip_tags($request['f_name']);
            $new_user->l_name = strip_tags($request['l_name']);
            $new_user->email = $email;
            $new_user->password = Hash::make($request['password']);

            $new_user->save();

            $req_registration->user_id = $new_user->id;
        } else {
            $req_registration->user_id = $user->id;
        }

        // To avoid having a file with the same name
        $newImageName = time() . '-' . Str::random(5) . '.' . $request['school_id']->extension();
        // Where to store the image
        $path = 'profile/school_id';
        // Store the image in public directory
        $request['school_id']->move(public_path($path), $newImageName);
        // Output would be like: game/BackgroundImage/image.png
        // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
        $req_registration->school_id = $path . '/' . $newImageName;

        $req_registration->save();
        
        return redirect()->route('web.login')->with(['msg' => 'Registered Successfully']);
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();
        $credentials['status'] = 'active';
        if (Auth::attempt($credentials)) {
            // Check if user has seen tutorial already
            if (!\Cache::has('tutorial_seen')) {
                // User hasn't seen tutorial, redirect to tutorial page
                return redirect()->route('web.narrative');
            }

            return redirect()
                ->route('web.play.index')
                ->with('msg', 'Login Successfully');
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

    public function profile_update(UpdateProfileRequest $request, $user)
    {
        $data = $request->validated();

        $id = decrypt($user);
        $user = User::findorfail($id);

        if ($data['action'] == 'picture') {
            // Make sure you delete the file first before deleting the record in db
            // But before that, you need to make sure that the file still exist in the first place
            if (!is_null($user->profile_picture) && file_exists($user->profile_picture)) {
                unlink($user->profile_picture);
            }
            // To avoid having a file with the same name
            $newImageName = time() . '-' . $user->l_name . '.' . $request['image']->extension();
            // Where to store the image
            $path = 'profile/picture';
            // Store the image in public directory
            $request['image']->move(public_path($path), $newImageName);
            // Output would be like: game/BackgroundImage/image.png
            // So we can just do something like asset($foo['path']) than asset(game/BackgroundImage/$foo['path'])
            $user->profile_picture = $path . '/' . $newImageName;
        }
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
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('web.login');
    }
}
