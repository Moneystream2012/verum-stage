<?php

namespace App\Providers;

use App\Administrator;
use App\Deposit;
use App\Issue;
use App\Observers\IssueObserver;
use App\Observers\TradingObserver;
use App\Observers\VerificationObserver;
use App\Trading;
use App\User;
use App\Verification;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Issue::observe(IssueObserver::class);
        Verification::observe(VerificationObserver::class);
        Trading::observe(TradingObserver::class);
    }

    /**
     * Register any application services.
     *
     * @param Relation $relation
     */
    public function register()
    {
        Relation::morphMap([
            'user'  => User::class,
            'admin' => Administrator::class,
            'deposit' => Deposit::class,
        ]);

        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
