<?php

namespace App\Jobs\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RankRemuneration implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    const PREMIUM_RANK = [
        // Director 1
        2 => [
            'turnover_binary' => 50000.00,
            'turnover_direct' => 5000.00,
            'reward'          => 1000.00,
        ],
        // Director 2
        3 => [
            'turnover_binary' => 100000.00,
            'turnover_direct' => 10000.00,
            'reward'          => 2000.00,
        ],
        // Director 3
        4 => [
            'turnover_binary' => 500000.00,
            'turnover_direct' => 50000.00,
            'reward'          => 10000.00,
        ],
        // Director 4
        5 => [
            'turnover_binary' => 1000000.00,
            'turnover_direct' => 100000.00,
            'reward'          => 25000.00,
        ],
        // Director 5
        6 => [
            'turnover_binary' => 3000000.00,
            'turnover_direct' => 0,
            'reward'          => 100000.00,
            'requirement'     => [
                'count' => 2,
                'rank'  => 5,
            ],
        ],
    ];

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->user->rank == 6) {
            return;
        }
        $rank = $this->user->rank < 2 ? 1 : $this->user->rank;
        $rank++;
        //dump('user_id => '.$this->user->id);
        //dump('rank => '.$rank);
        $premium_rank = self::PREMIUM_RANK[$rank];
        if ($this->user->premium_rank()->where('rank', $rank)->exists()) {
            return;
        }

        //dump('direct_all => '.$this->user->turnover2s->direct_all, $premium_rank['turnover_direct']);
        if (($this->user->turnover2s->direct_all ?? 0) < $premium_rank['turnover_direct']) {
            return;
        }

        //dump('binary_lower_branch => '.$this->user->binary_lower_branch , $premium_rank['turnover_binary']);

        if ($this->user->binary_lower_branch < $premium_rank['turnover_binary']) {
            return;
        }

        if (isset($premium_rank['requirement'])) {
            $count = $this->user->sponsors()->select([
                'rank',
            ])->where('rank', $premium_rank['requirement']['rank'])->count('rank');

            if ($count < $premium_rank['requirement']['count']) {
                return;
            }
        }
        $this->user->rank = $rank;
        //dump([
        //    'status'    => 'finish',
        //    'user_id'   => $this->user->id,
        //    'amount'    => $premium_rank['reward'],
        //    'rank'      => $rank,
        //    'rank_text' => $this->user->rank_text,
        //]);

        //return;
        $this->user->premium_rank()->create([
            'amount' => $premium_rank['reward'],
            'rank'   => $rank,
        ]);

        dispatch(new Histories($this->user->id, 'rank', 'profits', [
            'rank'   => $this->user->rank_text,
            'to'     => 'mining_balance',
            'amount' => formatUSD($premium_rank['reward']),
        ]));

        $this->user->investBalance('mining_balance', $premium_rank['reward']);
    }
}
