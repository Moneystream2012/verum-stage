<?php

namespace App\Jobs\User;

use App\Jobs\SmsNotify;
use App\Trading;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardTrading implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    /**
     * @var Trading
     */
    private $trading;

    /**
     * Create a new job instance.
     *
     * @param Trading $trading
     */
    public function __construct(Trading $trading)
    {
        $this->to = 'mining_balance';
        $this->trading = $trading;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        ++$this->trading->number_of;
        $amount = $this->trading->payout;
        $this->trading->profit += $amount;
        $this->trading->calculate_at = $this->trading->calculate_at->addDays(Trading::BETWEEN_PAYMENTS);
        $this->trading->save();

        if ($this->trading->payout_count == $this->trading->number_of) {
            $this->trading->status = Trading::FINAL;
            $this->trading->calculate_at = Carbon::now();
            $this->trading->save();
        }

        $user = $this->trading->user;
        $user->investBalance($this->to, $amount);
        $percent_payout = Trading::getPercentPayout();
        $user->rewards()->create([
            'from_id'   => $this->trading->id,
            'from_type' => 'trading',
            'to'        => $this->to,
            'amount'    => $amount,
            'data'      => [
                'number_of' => $this->trading->number_of,
                'percent'   => $percent_payout / 100,
                'invest'    => $this->trading->invest,
            ],
        ]);

        dispatch(new Histories($this->trading->user_id, 'trading', 'profits', [
            'id'        => $this->trading->id,
            'to'        => $this->to,
            'percent'   => $percent_payout,
            'number_of' => $this->trading->number_of_payout,
            'name'      => formatCurrency('USD', $this->trading->invest, true),
            'amount'    => formatCurrency('USD', $amount, true),
        ]));
        dispatch(new SmsNotify($user, 'reword-trading', ['amount' => $amount]));
    }
}
