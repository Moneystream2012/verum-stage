<?php

namespace App\Policies;

use App\Share;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Share $share)
    {
        return $user->id === $share->user_id;
    }
}
