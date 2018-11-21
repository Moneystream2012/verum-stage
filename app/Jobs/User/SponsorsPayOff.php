<?php

namespace App\Jobs\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SponsorsPayOff implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $data;

    private $percent = [
        1 => 0.07,
        2 => 0.04,
        3 => 0.02,
        4 => 0.01,
        5 => 0.01,
        6 => 0.01,
        7 => 0.01,
        8 => 0.01,
    ];

    /**
     * SponsorsPayOff constructor.
     *
     * @param \App\User $user
     * @param array $data
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = [
                'level' => 1,
                'sponsor_id' => $user->id,
                'sponsor_username' => $user->username,
                'amount' => 0,
                'percent' => 0,
            ] + $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($sponsor = $this->user->sponsor()->select('id', 'sponsor_id')->first()) {
            $this->payoff($sponsor);
        }
    }

    public function payoff(User $user)
    {

        if ($user->is_investor) {
            $this->data['percent'] = $this->percent[$this->data['level']];
            $this->data['amount'] = round($this->data['invest'] * $this->data['percent'], 2);
            $this->pay($user, $this->data);
        }

        dispatch(new Turnovers($user, $this->data));

        //1 лінія
        //if ($user->plan >= 1 && $this->data['level'] == 1 ) {
            //$this->pay($user, $this->data);
        //}

        //2 лінія
        /*if ($user->plan >= 6 && $user->plan <= 8 && $this->data['level'] == 2) {
            $this->pay($user, $this->data);
        }*/

        //3 лінія
        /*if ($user->plan == 9 && ($this->data['level'] == 2 || $this->data['level'] == 3)) {
            $this->pay($user, $this->data);
        }*/

        //4 лінія
        /*if (($user->plan == 10 || $user->plan == 11) && $this->data['level'] >= 2 && $this->data['level'] <= 4) {
            $this->pay($user, $this->data);
        }*/

        //5 лінія
        /*if ($user->plan == 12 && $this->data['level'] >= 2 && $this->data['level'] <= 5) {
            $this->pay($user, $this->data);
        }*/

        if ($this->data['level'] == 8) {
            return;
        }
        $this->data['level'] += 1;
        if ($user = $user->sponsor()->select('id', 'sponsor_id')->first()) {
            $this->payoff($user);
        }
    }

    protected function pay($user, $data)
    {
        dispatch(new RewardSponsorProduct($user, $data));
    }
}
