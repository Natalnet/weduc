<?php

namespace App\Policies;

use App\User;
use App\ProgrammingLanguage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgrammingLanguagePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the programmingLanguage.
     *
     * @param  \App\User  $user
     * @param  \App\ProgrammingLanguage  $programmingLanguage
     * @return mixed
     */
    public function view(User $user, ProgrammingLanguage $programmingLanguage)
    {
        //
    }

    /**
     * Determine whether the user can create programmingLanguages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the programmingLanguage.
     *
     * @param  \App\User  $user
     * @param  \App\ProgrammingLanguage  $programmingLanguage
     * @return mixed
     */
    public function update(User $user, ProgrammingLanguage $programmingLanguage)
    {
        return $user->id === $programmingLanguage->user_id;
    }

    /**
     * Determine whether the user can delete the programmingLanguage.
     *
     * @param  \App\User  $user
     * @param  \App\ProgrammingLanguage  $programmingLanguage
     * @return mixed
     */
    public function delete(User $user, ProgrammingLanguage $programmingLanguage)
    {
        //
    }
}
