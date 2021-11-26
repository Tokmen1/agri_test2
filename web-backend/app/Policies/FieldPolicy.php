<?php

namespace App\Policies;

use App\Models\Fields;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Fields $fields)
    {
        return $user->id === $user->fields->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Fields $fields)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Fields $fields)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Fields $fields)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Fields $fields)
    {
        return true;
    }
}
