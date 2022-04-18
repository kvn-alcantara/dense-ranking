<?php

namespace Tests\Traits;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait SignIn
{
    /**
     * Create a user and sign in as that user. If a user
     * object is passed, then sign in as that user.
     *
     * @param null $user
     * @return Collection|Model|null
     */
    public function signIn($user = null)
    {
        if (is_null($user)) {
            $user = User::factory()->has(Role::factory()->player())->create();
        }

        $this->actingAs($user);

        return $user;
    }
}

