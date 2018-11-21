<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Foundation\Application;
use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() && ! $request->is('administrator*', 'replenishment/callback*', 'opcache-api/*')) {
            $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }
}
