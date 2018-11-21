<?php

namespace App\Listeners\Users;

use App\Charity;
use App\Events\Users\TransferCharity;
use App\Jobs\User\Histories;

class NewCharity
{
    /**
     * Handle the event.
     *
     * @param TransferCharity $event
     */
    public function handle(TransferCharity $event)
    {
        $charity = $event->user->charities()->create($event->data);

        Charity::incrementAmount($charity->amount);

        flash()->success(trans('personal-office/products/charity.success'))->important();

        dispatch(new Histories($event->user->id, 'charities', 'transfers', [
            'id'     => $charity->id,
            'method' => $charity->method,
            'amount' => formatUSD($charity->amount),
        ]));
    }
}
