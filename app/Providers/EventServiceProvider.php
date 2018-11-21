<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //\SocialiteProviders\Manager\SocialiteWasCalled::class => [
        //    // add your listeners (aka providers) here
        //    'SocialiteProviders\VKontakte\VKontakteExtendSocialite@handle',
        //    'SocialiteProviders\Twitter\TwitterExtendSocialite@handle',
        //    'SocialiteProviders\Instagram\InstagramExtendSocialite@handle',
        //],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\Users\UpdateLastLoginAt',
        ],
        'App\Events\Users\Registered' => [
            'App\Listeners\Users\SendEmailRegistered',
            //'App\Listeners\Users\ActivateBinary',
        ],
        'App\Events\Users\PaymentDeposit' => [
            'App\Listeners\Users\NewDeposit',
        ],
        'App\Events\Users\InvestTrading' => [
            'App\Listeners\Users\NewTrading',
        ],
        'App\Events\Users\PaymentShares' => [
            'App\Listeners\Users\NewShares',
        ],
        'App\Events\Users\TransferCharity' => [
            'App\Listeners\Users\NewCharity',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
