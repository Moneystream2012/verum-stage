<?php

namespace App\Policies;

use App\User;
use App\Withdraw;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Withdraw $withdraw)
    {
        return $user->id === $withdraw->user_id;
    }
}
