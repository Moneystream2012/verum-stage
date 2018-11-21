<?php

namespace App\Http\Middleware;

use Closure;

class UserBlocked
{
    /**
     * @param $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (! $request->is('personal-office/blocked', 'personal-office/issues*', 'personal-office/notification', 'personal-office/logout') && auth()->user()->blocked) {
            return redirect()->route('personal-office.blocked');
        }

        if ($request->is('personal-office/blocked') && ! auth()->user()->blocked) {
            return redirect()->route('personal-office.dashboard');
        }

        return $next($request);
    }
}
