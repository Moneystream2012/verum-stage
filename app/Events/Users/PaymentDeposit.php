<?php

namespace App\Events\Users;

use App\Deposit;
use App\User;
use Illuminate\Queue\SerializesModels;

class PaymentDeposit
{
    use SerializesModels;

    public $user;

    public $deposit;

    /**
     * @var array
     */
    public $data;

    /**
     * PaymentDeposit constructor.
     *
     * @param \App\User $user
     * @param \App\Deposit $deposit
     * @param array $data
     */
    public function __construct(User $user, Deposit $deposit, array $data)
    {
        $this->user = $user;
        $this->deposit = $deposit;
        $this->data = $data;
    }
}
