<?php

namespace App\Providers;

use App\Extensions\TarantoolStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Cache::extend('tarantool', function ($app) {
            return Cache::repository(new TarantoolStore());
        });
    }
}
