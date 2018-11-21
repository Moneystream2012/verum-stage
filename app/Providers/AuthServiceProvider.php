<?php

namespace App\Providers;

use App\Deposit;
use App\Policies\DepositPolicy;
use App\Policies\ReplenishmentPolicy;
use App\Policies\SharePolicy;
use App\Policies\WithdrawPolicy;
use App\Replenishment;
use App\Share;
use App\Withdraw;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Deposit::class => DepositPolicy::class,
        Share::class   => SharePolicy::class,
        Replenishment::class => ReplenishmentPolicy::class,
        Withdraw::class => WithdrawPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
