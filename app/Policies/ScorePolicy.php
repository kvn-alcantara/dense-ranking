<?php

namespace App\Policies;

use App\Models\Score;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScorePolicy
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
        if ($user->hasRoles(['admin'])) {
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
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRoles(['player']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Score $score
     * @return bool
     */
    public function update(User $user, Score $score): bool
    {
        return $user->id === $score->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Score $score
     * @return bool
     */
    public function delete(User $user, Score $score): bool
    {
        return $user->id === $score->user_id;
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
