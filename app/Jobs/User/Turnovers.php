<?php

namespace App\Jobs\User;

use App\Turnover2;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Turnovers implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var array
     */
    private $data;

    /**
     * Turnovers constructor.
     *
     * @param \App\User $user
     * @param array $data
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $turnover = $this->user->turnover2s ?: new Turnover2;
        $turnover->direct_all += $this->data['level'] == 1
            ? $this->data['invest']
            : round($this->data['invest'] / 2, 2);
        $turnover->direct_total += $this->data['amount'];
        $turnover->calculate_at = Carbon::now();
        $this->user->turnover2s()->save($turnover);
    }

}
