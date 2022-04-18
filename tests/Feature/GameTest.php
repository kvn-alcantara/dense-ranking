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
                'user' => [
                    'id',
                    'name',
                ],
                'value',
                'created_at',
            ],
        ],
    ];

    public function test_it_gets_all_games()
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

    public function test_it_gets_a_specific_game()
    {
        $user = $this->signIn();

        $game = Game::factory()
            ->has(Score::factory()->for($user))
            ->create();

        $response = $this->getJson(route('games.show', $game));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->gameWithScoresJsonStructure,
            ]);
    }

    public function test_it_creates_a_game()
    {
        $user = User::factory()->has(Role::factory()->admin())->create();

        $this->signIn($user);

        $player = User::factory()->has(Role::factory()->player())->create();

        $data = [
            'name' => $this->faker->sentence(),
            'scores' => [
                [
                    'value' => $this->faker->numberBetween(0,100),
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
}
