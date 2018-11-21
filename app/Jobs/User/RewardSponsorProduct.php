<?php

namespace App\Jobs\User;

use App\Jobs\SmsNotify;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardSponsorProduct implements ShouldQueue
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
    private $to;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $data
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
        $this->to = 'balance';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->user->investBalance($this->to, $this->data['amount']);
        dispatch(new Histories($this->user->id, 'sponsor-'.$this->data['type'], 'profits', [
            'id' => $this->data['id'],
            'sponsor_username' => $this->data['sponsor_username'],
            'to' => $this->to,
            'level' => $this->data['level'],
            'invest' => formatCurrency('USD', $this->data['invest'], true),
            'percent' => $this->data['percent'] * 100,
            'amount' => formatCurrency('USD', $this->data['amount'], true),
        ]));

        dispatch(new SmsNotify($this->user, 'reword-sponsor', [
            'amount' => $this->data['amount'],
            'sponsor' => $this->data['sponsor_username'],
        ]));
    }
}
