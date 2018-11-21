<?php

namespace App\Jobs\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckTeamDeveloper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const IS_PLAN = 1;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var int
     */
    protected $level;

    /**
     * CheckTeamDeveloper constructor.
     *
     * @param \App\User $user
     * @param int $level
     */
    public function __construct(User $user, int $level = 0)
    {
        $this->user = $user;
        $this->level = $level;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user->plan < self::IS_PLAN) {
            return;
        }
        //dump('level: '. $this->level.'; user id: '.$this->user->id);
        if (! $this->user->team_developer) {
            $rows = $this->user->sponsors()->sponsorPlan(self::IS_PLAN)
                ->with([
                    'sponsors' => function ($q) {
                        return $q->sponsorPlan(self::IS_PLAN);
                    },
                ])
                ->get()->filter(function ($item) {
                    return $item->sponsors->unique('leg')->count() == 2;
                })->unique('leg');

            if ($rows->count() == 2) {
                //dump('user id: '.$this->user->id.' team_developer :'.true);

                //return;
                if ($this->user->rank == '0') {
                    $this->user->rank = '1';
                }
                $this->user->setSetting(['team_developer' => true]);
            }
        }

        if ($this->user->sponsor && $this->level != 2) {
            dispatch(new CheckTeamDeveloper($this->user->sponsor, ++$this->level));
        }
    }
}
