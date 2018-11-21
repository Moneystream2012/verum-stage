<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        Route::pattern('user_id', '[0-9]+');
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapAdministratorRoutes();
        $this->mapUserRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => [
                'web',
            ],
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    protected function mapUserRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'as'         => 'personal-office.',
            'namespace'  => $this->namespace,
        ], function ($router) {
            require base_path('routes/user.php');
        });
    }

    protected function mapAdministratorRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'as'         => 'administrator.',
            'namespace'  => $this->namespace,
        ], function ($router) {
            require base_path('routes/administrator.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace'  => $this->namespace,
            'prefix'     => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
