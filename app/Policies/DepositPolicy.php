<?php

namespace App\Policies;

use App\User;
use App\Deposit;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepositPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the deposit.
     *
     * @param \App\User    $user
     * @param \App\Deposit $deposit
     *
     * @return mixed
     */
    public function view(User $user, Deposit $deposit)
    {
    }

    /**
     * Determine whether the user can create deposits.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the deposit.
     *
     * @param \App\User    $user
     * @param \App\Deposit $deposit
     *
     * @return mixed
     */
    public function update(User $user, Deposit $deposit)
    {
        return $user->id === $deposit->user_id;
    }

    /**
     * Determine whether the user can delete the deposit.
     *
     * @param \App\User    $user
     * @param \App\Deposit $deposit
     *
     * @return mixed
     */
    public function delete(User $user, Deposit $deposit)
    {
    }
}
