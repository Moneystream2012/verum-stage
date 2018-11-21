<?php

namespace App\Events\Users;

use App\Trading;
use App\User;
use Illuminate\Queue\SerializesModels;

class InvestTrading
{
    use SerializesModels;
    /**
     * @var User
     */
    public $user;
    /**
     * @var Trading
     */
    public $trading;
    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Trading $trading
     * @param array $data
     */
    public function __construct(User $user, Trading $trading, array $data)
    {
        $this->user = $user;
        $this->trading = $trading;
        $this->data = $data;
    }
}
