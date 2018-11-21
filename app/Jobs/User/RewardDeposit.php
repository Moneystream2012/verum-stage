<?php

namespace App\Jobs\User;

use App\Deposit;
use App\Jobs\SmsNotify;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardDeposit implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Deposit
     */
    private $deposit;

    private $to;

    /**
     * Create a new job instance.
     *
     * @param \App\Deposit $deposit
     */
    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
        $this->to = 'mining_balance';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        ++$this->deposit->number_of;
        $amount = $this->deposit->payout;
        $this->deposit->profit += $amount;
        $this->deposit->calculate_at = $this->deposit->calculate_at->addDays($this->deposit::BETWEEN_PAYMENTS);
        $this->deposit->save();

        if ($this->deposit->payout_count == $this->deposit->number_of) {
            $this->deposit->active = false;
            $this->deposit->calculate_at = Carbon::now();
            $this->deposit->save();
        }

        $user = $this->deposit->user;
        $user->investBalance($this->to, $amount);
        $percent_payout = $this->deposit->percent_payout;
        $user->rewards()->create([
            'from_id'   => $this->deposit->id,
            'from_type' => 'deposit',
            'to'        => $this->to,
            'amount'    => $amount,
            'data'      => [
                'number_of' => $this->deposit->number_of,
                'percent'   => $percent_payout,
                'plan'      => $this->deposit->plan,
                'invest'    => $this->deposit->invest,
            ],
        ]);

        dispatch(new Histories($this->deposit->user_id, 'deposit', 'profits', [
            'id'        => $this->deposit->id,
            'to'        => $this->to,
            'percent'   => $percent_payout,
            'number_of' => $this->deposit->number_of.' / '.$this->deposit->payout_count,
            'name'      => formatCurrency('USD', $this->deposit->invest, true),
            'amount'    => formatCurrency('USD', $amount, true),
        ]));
        dispatch(new SmsNotify($user, 'reword-deposit', ['amount' => $amount]));
    }
}
