<?php

namespace App\Http\Middleware;

use Closure;

class WebLocale
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
        $raw_locale = $request->session()->get('web_locale');
        if (in_array($raw_locale, config('app.locales'))) {
            app()->setLocale($raw_locale);
        }

        return $next($request);
    }
}
