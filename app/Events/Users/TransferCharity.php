<?php

namespace App\Events\Users;

use App\User;
use Illuminate\Queue\SerializesModels;

class TransferCharity
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
