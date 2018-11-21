<?php

namespace App\Listeners\Users;

use App\Events\Users\InvestTrading;
use App\Jobs\User\Histories;
use App\Jobs\User\SponsorsPayOff;

class NewTrading
{
    /**
     * Handle the event.
     *
     * @param  InvestTrading $event
     * @return void
     */
    public function handle(InvestTrading $event)
    {
        dispatch(new Histories($event->user->id, 'trading', 'payments', [
            'id' => $event->trading->id,
            'method' => $event->data['method'],
            'amount' => formatCurrency($event->data['currency'], $event->trading->invest, true),
        ]));

        if ($event->data['method'] == 'cold_balance') return;

        dispatch(new SponsorsPayOff($event->user, [
            'id' => $event->trading->id,
            'invest' => $event->trading->invest,
            'type' => 'trading'
        ]));
    }
}
