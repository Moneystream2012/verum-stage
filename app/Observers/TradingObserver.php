<?php

namespace App\Observers;

use App\Trading;

class TradingObserver
{
    public function creating(Trading $model)
    {
        $model->calculate_at = $model->freshTimestamp()->addDays(Trading::BETWEEN_PAYMENTS);
        $model->final_at = $model->freshTimestamp()->addDays(Trading::PAYOUT_COUNT);
    }
}
