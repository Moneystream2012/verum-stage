<?php

namespace App\Jobs\User;

use App\Compute;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RewardMatchingBonus implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    const RANK_OF_PERCENT = [
        // TeamDeveloper
        1 => [
            0.10,
        ],
        // Director 1
        2 => [
            0.10,
            0.10,
        ],
        // Director 2
        3 => [
            0.10,
            0.10,
            0.05,
        ],
        // Director 3
        4 => [
            0.10,
            0.10,
            0.05,
            0.05,
            0.05,
        ],
        // Director 4
        5 => [
            0.10,
            0.10,
            0.05,
            0.05,
            0.05,
            0.05,
            0.05,
            0.05,
        ],
        // Director 5
        6 => [
            0.10,
            0.10,
            0.05,
            0.05,
            0.05,
            0.05,
            0.05,
            0.05,
            0.05,
            0.05,
        ],
    ];

    /**
     * @var \App\User;
     */
    private $user;

    private $data;

    /**
     * @var
     */
    private $number_of;

    /**
     * SponsorsPayOff constructor.
     *
     * @param \App\User $user
     * @param $data
     * @param $number_of
     * @internal param $user_sponsor_id
     * @internal param float $amount
     */
    public function __construct(User $user, $data, $number_of)
    {
        $this->user = $user;
        $this->data = $data;
        $this->number_of = $number_of;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $amount = 0;
        $reward = 0;
        $max_level = count(array_get(self::RANK_OF_PERCENT, $this->user->rank));

        for ($i = 0; $i < $max_level; $i++) {
            if ($percent = array_get(self::RANK_OF_PERCENT, $this->user->rank.'.'.$i)) {
                $resAmount = $this->getSumAmountIds($i);
                $reward += $resAmount;
                $amount += $percent * $resAmount;
            }
        }
        dump($this->user->id, '=', $max_level, $amount, $reward);

        $amount = $amount > (float) $this->user->product['price'] ? (float) $this->user->product['price'] : $amount;
        //return;
        $this->user->computes()->create([
            'from'        => 'matching',
            'to'          => 'balance',
            'amount'      => $amount,
            'plan'        => $this->user->plan,
            'rank'        => $this->user->rank,
            'reward'      => $reward,
            'status'      => Compute::STATUS_SUCCESS,
            'point_left'  => 0,
            'point_right' => 0,
            'number_of'   => $this->number_of,
            'computed_at' => Carbon::now(),
        ]);
        $this->user->investBalance('balance', $amount);
        dispatch(new Histories($this->user->id, 'matching_bonus', 'profits', [
            'to'        => 'balance',
            'percent'   => $percent * 100,
            'amount'    => formatUSD($amount),
            'number_of' => $this->number_of,
        ]));
    }

    /**
     * @param $level
     * @return float
     */
    private function getSumAmountIds($level): float
    {
        //$users_id = array_slice($users_id, 0, $level);
        $amount = Compute::whereIn('user_id', array_collapse($this->data[$level]))
            ->where('from', '<>', 'matching')
            ->where('computed_at', '>=', new Carbon('last monday'))
            ->select('amount')
            ->sum('amount');

        return (float) $amount;
    }
}
