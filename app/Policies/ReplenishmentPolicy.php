<?php

namespace App\Policies;

use App\Replenishment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplenishmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Replenishment $replenishment)
    {
        return $user->id === $replenishment->user_id;
    }
}
