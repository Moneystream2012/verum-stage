<?php

namespace App\Jobs\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardSponsorShares implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $data
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $profit_amount = round($this->data['product']['total'] * ($this->data['level'] == 1 ? config('mlm.rewards.shares.level1') : config('mlm.rewards.shares.level2-5')), 2);
        $this->user->investBalance('balance', $profit_amount);
        dispatch(new Histories($this->user->id, 'sponsor-shares', 'profits', [
            'id'         => $this->data['sponsor_id'],
            'to'         => 'balance',
            'level'      => $this->data['level'],
            'price'      => formatUSD($this->data['product']['total']),
            'leg'        => $this->data['leg'],
            'name'       => $this->data['sponsor_username'],
            'deposit_id' => $this->data['product']['id'],
            'amount'     => formatUSD($profit_amount),
        ]));
    }
}
