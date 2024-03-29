<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangeEmailVerifiedMail;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()
                ->route('web.login')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->route('web.login')
                ->with('error', 'Your email address is already verified.');
        }

        $user->markEmailAsVerified();

        event(new Verified($user));

        event(new \App\Events\UserRequestRegistration('Hello World'));

        Auth::login($user);

        return redirect()->route('web.play.index');
    }

    public function update_verify(Request $request)
    {
        $user = User::findOrFail($request['id']);

        // Check if the token in the request matches the expected token
        $expectedToken = hash_hmac('sha256', $user->id . $request['email'], env('APP_KEY'));

        $actualToken = $request['token'];
        if (!hash_equals($expectedToken, $actualToken)) {
            return redirect()
                ->route('web.login')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->email == $request['email']) {
            return redirect()
                ->route('web.login')
                ->with('error', 'Your email address has already been verified.');
        }
        $old_email = $user->email;
        $user->email = $request['email'];
        $user->email_verified_at = now();
        $user->save();

        Mail::to($old_email)->send(new ChangeEmailVerifiedMail($user->l_name));

        Auth::login($user);

        return redirect()
            ->route('web.play.index')
            ->with('msg', 'Your new email address has been verified.');
    }
}
