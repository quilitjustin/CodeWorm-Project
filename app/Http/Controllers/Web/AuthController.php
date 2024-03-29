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
            return redirect()->route('web.play.index');
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
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!strpos($value, '.')) {
                        $fail('The email must have a valid top-level domain.');
                    }
                },
            ],
            'password' => ['required', 'min:8', 'confirmed'],
            'school_id' => ['required'],
            'terms' => ['required'],
        ]);

        $email = strip_tags($request['email']);
        $user = User::select('id')
            ->where('email', $email)
            ->first();
        
        if (is_null($user)) {
            $user = new User();
            $user->f_name = strip_tags($request['f_name']);
            if(!is_null($request['m_name'])){
                $user->m_name = $this->capitalize($request['m_name']);
            }
            $user->l_name = strip_tags($request['l_name']);
            $user->email = $email;
            $user->password = Hash::make($request['password']);

            $user->save();

            $req_registration = new RequestRegistration();
            $req_registration->user_id = $user->id;
        } else {
            $req_registration = RequestRegistration::select('status')->where('user_id', $user->id)->first();
            if ($req_registration->status == 'pending') {
                return redirect()
                    ->back()
                    ->with(['error' => 'Currently have an ongoing request!']);
            }
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

        $url = route('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $user->sendEmailVerificationNotification($url);

        // event(new \App\Events\UserRequestRegistration('Hello World'));

        Auth::login($user);

        return redirect()->route('web.play.index');
    }

    public function authenticate(LoginRequest $request)
    {
        if (Auth::check()) {
            return redirect()->route('web.play.index');
        }
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            if (!is_null(Auth::user()->suspended_until)) {
                Auth::logout();
                return redirect()
                    ->route('web.login')
                    ->with(['error' => 'Suspended until ' . Auth::user()->suspended_until, '.']);
            }

            // if (is_null(Auth::user()->email_verified_at)) {
            //     Auth::logout();
            //     return redirect()
            //         ->route('web.login')
            //         ->with(['error' => 'You must verify your email first.']);
            // }

            // $req = RequestRegistration::select('status')
            //     ->where('user_id', Auth::user()->id)
            //     ->first();

            // if ($req->status != 'accepted' && Auth::user()->role != 'superadmin') {
            //     Auth::logout();
            //     return redirect()
            //         ->route('web.login')
            //         ->with(['error' => 'The admin must accept your registration first.']);
            // }

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

    public function upload_picture()
    {
        return view('web.auth.upload_picture');
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
            ->route('web.profile')
            ->with(['msg' => 'Updated Successfully']);
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('web.login');
        }
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('web.login');
    }
}
