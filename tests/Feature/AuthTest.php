<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_login_with_correct_credentials()
    {
        $user = User::factory()->has(Role::factory()->player())->create();

        $data = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        $response = $this->postJson(route('login'), $data);

        $response
            ->assertOk()
            ->assertValid()
            ->assertJsonStructure([
                'access_token',
            ]);
    }

    public function test_cannot_login_with_incorrect_credentials()
    {
        $data = [
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ];

        $response = $this->postJson(route('login'), $data);

        $response->assertUnauthorized();
    }

    public function test_it_register_a_new_user_with_valid_fields()
    {
        Role::factory()->admin()->create();
        Role::factory()->player()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->postJson(route('register'), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
            ]);
    }

    public function test_cannot_register_a_new_user_with_invalid_fields()
    {
        $data = [
            'name' => $this->faker->name(),
            'password' => 'secret',
        ];

        $response = $this->postJson(route('register'), $data);

        $response
            ->assertInvalid(['email', 'password'])
            ->assertUnprocessable();
    }

    public function test_cannot_register_a_user_with_existing_email()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->postJson(route('register'), $data);

        $response
            ->assertInvalid(['email'])
            ->assertUnprocessable();
    }

    public function test_user_can_logout()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson(route('logout'));

        $response->assertOk();
    }
}
