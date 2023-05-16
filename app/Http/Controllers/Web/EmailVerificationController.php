<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;

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

        return redirect()
            ->route('web.login')
            ->with('msg', 'Your email address has been verified.');
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

        $user->email = $request['email'];
        $user->email_verified_at = now();
        $user->save();

        return redirect()
            ->route('web.login')
            ->with('msg', 'Your email address has been verified.');
    }
}
