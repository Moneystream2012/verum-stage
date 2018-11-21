<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'user' && ! $request->is('administrator/*')) {
                flash()->error(trans('auth.signed_in-error'));

                return redirect()->route('personal-office.dashboard');
            }
            if ($guard == 'administrator' && ! $request->is('personal-office/*')) {
                return redirect()->route('administrator.dashboard');
            }

            return redirect('/');
        }

        return $next($request);
    }
}
