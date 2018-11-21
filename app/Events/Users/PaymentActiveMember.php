<?php

namespace App\Events\Users;

use App\User;
use Illuminate\Queue\SerializesModels;

class PaymentActiveMember
{
    use SerializesModels;

    public $user;

    public $method;

    public $amount;

    public function __construct(User $user, $method, $amount)
    {
        $this->user = $user;
        $this->method = $method;
        $this->amount = $amount;
    }
}
