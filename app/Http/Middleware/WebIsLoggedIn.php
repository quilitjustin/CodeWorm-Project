<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestRegistration;

class WebIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth()->check()) {
            return redirect()->route('web.login');
        }

        if (!is_null(Auth::user()->id)) {
            $id = Auth::user()->id;

            $status = RequestRegistration::where('user_id', $id)->value('status');

            // $id == 1 = to admin / superadmin
            if (is_null(Auth::user()->email_verified_at) && $request->route()->getName() !== 'web.email_verify' && $id != 1) {
                return redirect()->route('web.email_verify');
            }

            // $id == 1 = to admin / superadmin
            if ($status == 'pending' && !is_null(Auth::user()->email_verified_at) && $request->route()->getName() !== 'web.email_verify.success' && $id != 1) {
                return redirect()->route('web.email_verify.success');
            }
        }

        return $next($request);
    }
}
