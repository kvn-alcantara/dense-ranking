<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class GamePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @return void|bool
     */
    public function before(User $user)
    {
        if ($user->hasRoles([Role::ADMIN])) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return bool
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return bool
     */
    public function update(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return bool
     */
    public function delete(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool
     */
    public function restore(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return bool
     */
    public function forceDelete(): bool
    {
        return false;
    }
}
