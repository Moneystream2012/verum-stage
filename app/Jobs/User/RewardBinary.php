<?php

namespace App\Jobs\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[] user
 */
class RewardBinary implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $reward;

    private $user;

    private $point_left;

    private $point_right;

    /**
     * RewardBinary constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->user = User::find($data[0]);
        $this->point_left = $data[1];
        $this->point_right = $data[2];
        $this->reward = $data[3];
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $amount = round($this->reward * $this->user->product['mlm_binary_bonus'], 2);

        if ($amount > 0) {
            dump('+++ user_id => '.$this->user->id, 'amount => '.$amount);
            $this->user->increment('balance', $amount);
            $this->user->increment('binary_total', $amount);
        } else {
            dump('user_id => '.$this->user->id, 'amount => '.$amount);
        }

        //$this->user->increment('binary_week', $amount);
        dispatch(new Histories($this->user->id, 'binary', 'profits', [
            'to'      => 'balance',
            'bonus'   => $this->user->product['mlm_binary_bonus'] * 100,
            'point_l' => formatUSD($this->point_left),
            'point_r' => formatUSD($this->point_right),
            'amount'  => formatUSD($amount),
        ]));
    }
}
