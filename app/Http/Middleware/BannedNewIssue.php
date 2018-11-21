<?php

namespace App\Http\Middleware;

use Closure;

class BannedNewIssue
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
        if (auth()->user()->issues()->whereIn('status', [0, 1])->exists()) {
            flash()->warning('У Вас уже есть открытая проблема! Ожидайте завершения проблеми для создания новой.')->important();

            return redirect()->back();
        }

        return $next($request);
    }
}
