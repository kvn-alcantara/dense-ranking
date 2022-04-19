<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Role;
use App\Models\Score;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\SignIn;

class GameTest extends TestCase
{
    use RefreshDatabase, WithFaker, SignIn;

    protected $gameWithScoresJsonStructure = [
        'id',
        'name',
        'scores' => [
            '*' => [
                'position',
                'value',
                'user' => [
                    'id',
                    'name',
                ],
                'created_at',
            ],
        ],
    ];

    public function test_it_gets_games()
    {
        $this->signIn();

        Game::factory()->count(5)->create();

        $response = $this->getJson(route('games.index'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        '_links' => [],
                    ],
                ],
            ]);
    }

    public function test_calling_games_gets_an_error_if_unauthenticated() {
        $response = $this->getJson(route('games.index'));

        $response->assertUnauthorized();
    }

    public function test_it_gets_a_specific_game()
    {
        $user = $this->signIn();

        $game = Game::factory()
            ->has(Score::factory()->for($user)->count(15))
            ->create();

        $response = $this->getJson(route('games.show', $game))->dump();

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->gameWithScoresJsonStructure,
            ]);
    }

    public function test_calling_specific_game_gets_an_error_if_unauthenticated()
    {
        $user = User::factory()->has(Role::factory()->player())->create();

        $game = Game::factory()
            ->has(Score::factory()->for($user)->count(15))
            ->create();

        $response = $this->getJson(route('games.show', $game));

        $response->assertUnauthorized();
    }

    public function test_it_creates_a_game_with_valid_fields()
    {
        $admin = User::factory()->has(Role::factory()->admin())->create();
        $player = User::factory()->has(Role::factory()->player())->create();

        $this->signIn($admin);

        $data = [
            'name' => $this->faker->sentence(),
            'scores' => [
                [
                    'value' => 5,
                    'user_id' => $player->id,
                ],
                [
                    'value' => 10,
                    'user_id' => $player->id,
                ],
                [
                    'value' => 10,
                    'user_id' => $player->id,
                ],
                [
                    'value' => 15,
                    'user_id' => $player->id,
                ],
                [
                    'value' => 9,
                    'user_id' => $player->id,
                ],
            ]
        ];

        $response = $this->postJson(route('games.store'), $data);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->gameWithScoresJsonStructure,
            ]);
    }

    public function test_creating_game_gets_an_error_if_fields_are_invalid()
    {
        $admin = User::factory()->has(Role::factory()->admin())->create();

        $this->signIn($admin);

        $data = [
            'name' => $this->faker->sentence(),
            'scores' => [
                [
                    'value' => 'lol',
                    'user_id' => 0,
                ],
            ]
        ];

        $response = $this->postJson(route('games.store'), $data)->dump();

        $response
            ->assertInvalid(['scores.0.value', 'scores.0.user_id'])
            ->assertUnprocessable();
    }

    public function test_creating_game_gets_an_error_if_unauthenticated()
    {
        $response = $this->postJson(route('games.store'), []);

        $response->assertUnauthorized();
    }

    public function test_it_updates_a_game_with_valid_fields()
    {
        $admin = User::factory()->has(Role::factory()->admin())->create();

        $this->signIn($admin);

        $game = Game::factory()->create();

        $data = [
            'name' => 'Test',
        ];

        $response = $this->putJson(route('games.update', $game), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->gameWithScoresJsonStructure
            ]);
    }
}
