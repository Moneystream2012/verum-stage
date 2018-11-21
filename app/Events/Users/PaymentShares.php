<?php

namespace App\Events\Users;

use App\User;
use Illuminate\Queue\SerializesModels;

class PaymentShares
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var array
     */
    public $data;

    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }
}
