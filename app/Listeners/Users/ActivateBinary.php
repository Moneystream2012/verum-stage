<?php

namespace App\Listeners\Users;

use App\Events\Users\Registered;
use Carbon\Carbon;

class ActivateBinary
{
    public function handle(Registered $event)
    {
        if (! $event->user->active) {
            cache()->store('tarantool')->getCall('new_user_binary', [
                (int) $event->user->id,
                (int) $event->user->sponsor_id,
                (string) $event->user->username,
                (int) $event->user->leg,
            ]);

            /*if ($binary_side[0] != null && ! $binary_side[0]['read']) {
                $sponsor = User::find($binary_side[0]['user_id']);
                if (! $sponsor->team_developer) {
                    $sponsor->side_leg = $sponsor->leg;
                    $sponsor->setSetting(['team_developer' => true]);
                    $sponsor->notify(new ActivationBinarySide());
                }
            }*/
        }

        $event->user->update([
            'active_at' => Carbon::now()->addYear(),
            'active'    => true,
        ]);
    }
}
