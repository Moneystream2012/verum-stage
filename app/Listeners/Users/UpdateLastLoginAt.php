<?php

namespace App\Listeners\Users;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    public function handle(Login $event)
    {
        if (get_class($event->user) == 'App\User') {
            $event->user->last_login_at = Carbon::now();
            $event->user->save();
        }
    }
}
