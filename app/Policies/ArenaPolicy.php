<?php

namespace App\Policies;

use App\User;
use App\Arena;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArenaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the arena.
     *
     * @param  \App\User  $user
     * @param  \App\Arena  $arena
     * @return mixed
     */
    public function view(User $user, Arena $arena)
    {
        return true;
    }

    /**
     * Determine whether the user can create arenas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('coach');
    }

    /**
     * Determine whether the user can update the arena.
     *
     * @param  \App\User  $user
     * @param  \App\Arena  $arena
     * @return mixed
     */
    public function update(User $user, Arena $arena)
    {
        return $user->id === $arena->user_id;
    }

    /**
     * Determine whether the user can delete the arena.
     *
     * @param  \App\User  $user
     * @param  \App\Arena  $arena
     * @return mixed
     */
    public function delete(User $user, Arena $arena)
    {
        return $user->id === $arena->user_id;
    }
}
