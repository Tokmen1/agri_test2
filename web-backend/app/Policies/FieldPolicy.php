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
	// dd("JANIS", $user->id === $fields->user_id);
        return $user->id === $fields->user_id;
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
        return $user->id === $fields->user_id;
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
        return $user->id === $fields->user_id;
    }

    public function accessSowing(User $user, Fields $fields, Sowing $sowing)
    {
        return $user->id === $fields->user_id;
    }
}
