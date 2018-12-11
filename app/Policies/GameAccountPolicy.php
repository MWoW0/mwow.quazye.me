<?php

namespace App\Policies;

use App\Enums\UserType;
use App\GameAccount;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the game account.
     *
     * @param  \App\User $user
     * @param  \App\GameAccount $gameAccount
     * @return mixed
     */
    public function view(User $user, GameAccount $gameAccount)
    {
        if ($user->type === UserType::Admin) {
            return true;
        }

        return $user->gameAccounts->contains($gameAccount);
    }

    /**
     * Determine whether the user can create game accounts.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can update the game account.
     *
     * @param  \App\User $user
     * @param  \App\GameAccount $gameAccount
     * @return mixed
     */
    public function update(User $user, GameAccount $gameAccount)
    {
        if ($user->type === UserType::Admin) {
            return true;
        }

        return $user->gameAccounts->contains($gameAccount);
    }

    /**
     * Determine whether the user can delete the game account.
     *
     * @param  \App\User $user
     * @param  \App\GameAccount $gameAccount
     * @return mixed
     */
    public function delete(User $user, GameAccount $gameAccount)
    {
        if ($user->type === UserType::Admin) {
            return true;
        }

        return $user->gameAccounts->contains($gameAccount);
    }

    /**
     * Determine whether the user can restore the game account.
     *
     * @param  \App\User $user
     * @param  \App\GameAccount $gameAccount
     * @return mixed
     */
    public function restore(User $user, GameAccount $gameAccount)
    {
        if ($user->type === UserType::Admin) {
            return true;
        }

        return $user->gameAccounts->contains($gameAccount);
    }

    /**
     * Determine whether the user can permanently delete the game account.
     *
     * @param  \App\User $user
     * @param  \App\GameAccount $gameAccount
     * @return mixed
     */
    public function forceDelete(User $user, GameAccount $gameAccount)
    {
        return $user->type === UserType::Admin;
    }
}
