<?php

namespace App\Listeners\Users;

use App\Events\Users\PaymentShares;
use App\Jobs\User\BinaryPointCalculate;
use App\Jobs\User\Histories;
use App\Jobs\User\SponsorsPayOff;
use App\Share;

class NewShares
{
    /**
     * Handle the event.
     *
     * @param PaymentShares $event
     */
    public function handle(PaymentShares $event)
    {
        $share = $event->user->shares()->create($event->data);
        Share::incrementCount($event->data['number_of']);

        dispatch(new Histories($event->user->id, 'shares', 'payments', [
            'id'        => $share->id,
            'number_of' => $share->number_of,
            'method'    => $share->method,
            'amount'    => formatUSD($share->amount),
        ]));

        dispatch(new SponsorsPayOff($event->user, [
            'type'  => 'shares',
            'id'    => $share->id,
            'total' => $share->amount,
        ]));

        dispatch(new BinaryPointCalculate([
            $event->user->id,
            round($share->amount * 0.70, 2),
        ]));

        flash()->success(trans('personal-office/products/shares.success'))->important();
    }
}
