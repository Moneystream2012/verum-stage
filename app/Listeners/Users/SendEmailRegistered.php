<?php

namespace App\Listeners\Users;

use App\Events\Users\Registered;
use App\Mail\Users\Registered as MailRegistered;
use Carbon\Carbon;
use Mail;

class SendEmailRegistered
{
    public function handle(Registered $event)
    {
        $event->data['url_verify'] = route('personal-office.verify_email', $event->user->token_email);

        try {
            Mail::to($event->user)->send(new MailRegistered($event->data));

            if (! $event->user->active) {
                cache()->store('tarantool')->getCall('new_user_binary', [
                    (int) $event->user->id,
                    (int) $event->user->sponsor_id,
                    (string) $event->user->username,
                    (int) $event->user->leg,
                ]);

            }

            $event->user->update([
                'active_at' => Carbon::now()->addYear(),
                'active'    => true,
            ]);
        } catch (\Exception $exception) {
            $event->user->delete();
            flash()->error('Whoops! Invalid email address.');
            //dd(redirect()->back());
            return redirect()->back();
        }


    }
}
