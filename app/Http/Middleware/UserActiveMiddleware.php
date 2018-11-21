<?php

namespace App\Http\Middleware;

use Closure;

class UserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->is('personal-office/active') && ! \Auth::user()->active_year) {
            return redirect()->route('personal-office.active_member');
        }

        if ($request->is('personal-office/active') && \Auth::user()->active_year) {
            return redirect()->route('personal-office.dashboard');
        }

        return $next($request);
    }
}
