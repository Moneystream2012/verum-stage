<?php

namespace App\Listeners\Users;

use App\Events\Users\PaymentDeposit;
use App\Jobs\User\Histories;
use App\Jobs\User\SponsorsPayOff;

class NewDeposit
{
    /**
     * @param \App\Events\Users\PaymentDeposit $event
     */
    public function handle(PaymentDeposit $event)
    {
        dispatch(new Histories($event->user->id, 'deposit', 'payments', [
            'id'     => $event->deposit->id,
            'method' => $event->data['method'],
            'amount' => formatCurrency($event->data['currency'], $event->deposit->invest, true),
        ]));
        if ($event->data['method'] == 'cold_balance') return;

//        if ($event->product['currency'] == 'BTC'){
//            $event->product['price'] = BTCtoUSD($event->product['price']);
//        }

        /*dispatch(new BinaryPointCalculate([
            $event->user->id,
            $event->deposit->invest,
        ]));*/

        dispatch(new SponsorsPayOff($event->user, [
            'id' => $event->deposit->id,
            'invest' => $event->deposit->invest,
            'type' => 'deposit',
        ]));
    }
}
