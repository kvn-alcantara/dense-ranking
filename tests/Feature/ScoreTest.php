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

class ScoreTest extends TestCase
{
    use RefreshDatabase, WithFaker, SignIn;

    protected $scoreJsonStructure = [
        'id',
        'position',
        'value',
        'player' => [
            'user_id',
            'name',
        ],
        'created_at',
        '_links' => [],
    ];

    public function test_it_gets_scores_for_a_specific_game()
    {
        $this->signIn();

        $game = Game::factory()->has(Score::factory()->count(5))->create();

        $response = $this->getJson(route('games.scores.index', $game));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->scoreJsonStructure,
                ],
            ]);
    }

    public function test_calling_scores_gets_an_error_if_unauthenticated() {
        $game = Game::factory()->create();

        $response = $this->getJson(route('games.scores.index', $game));

        $response->assertUnauthorized();
    }

    public function test_it_gets_a_specific_score()
    {
        $user = $this->signIn();

        $score = Score::factory()->for($user)->create();

        $response = $this->getJson(route('scores.show', $score));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->scoreJsonStructure,
            ]);
    }

    public function test_calling_specific_score_gets_an_error_if_unauthenticated()
    {
        $user = User::factory()->has(Role::factory()->player())->create();

        $score = Score::factory()->for($user)->create();

        $response = $this->getJson(route('games.show', $score));

        $response->assertUnauthorized();
    }

    public function test_it_creates_a_score_with_valid_fields()
    {
        $user = $this->signIn();

        $game = Game::factory()->create();

        $data = [
            'user_id' => $user->id,
            'value' => rand(1, 10),
        ];

        $response = $this->postJson(route('games.scores.store', $game), $data);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->scoreJsonStructure,
            ]);
    }

    public function test_creating_score_gets_an_error_if_fields_are_invalid()
    {
        $this->signIn();

        $game = Game::factory()->create();

        $data = [
            'user_id' => 0,
            'value' => '-1',
        ];

        $response = $this->postJson(route('games.scores.store', $game), $data);

        $response
            ->assertInvalid(['value', 'user_id'])
            ->assertUnprocessable();
    }

    public function test_creating_score_gets_an_error_if_unauthenticated()
    {
        $game = Game::factory()->create();

        $response = $this->postJson(route('games.scores.store', $game), []);

        $response->assertUnauthorized();
    }

    public function test_admin_can_update_a_score_with_valid_fields()
    {
        $admin = User::factory()->has(Role::factory()->admin())->create();

        $player = User::factory()->has(Role::factory()->player())->create();

        $this->signIn($admin);

        $score = Score::factory()->for($player)->create();

        $data = [
            'value' => 15,
        ];

        $response = $this->putJson(route('scores.update', $score), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->scoreJsonStructure
            ]);
    }

    public function test_updating_a_score_gets_an_error_if_fields_are_invalid()
    {
        $admin = User::factory()->has(Role::factory()->admin())->create();

        $player = User::factory()->has(Role::factory()->player())->create();

        $this->signIn($admin);

        $score = Score::factory()->for($player)->create();

        $data = [
            'value' => '-1',
        ];

        $response = $this->putJson(route('scores.update', $score), $data);

        $response
            ->assertInvalid(['value'])
            ->assertUnprocessable();
    }

    public function test_updating_a_score_gets_an_error_if_user_is_a_player()
    {
        $player = $this->signIn();

        $score = Score::factory()->for($player)->create();

        $data = [
            'value' => '1',
        ];

        $response = $this->putJson(route('scores.update', $score), $data);

        $response
            ->assertForbidden();
    }

    public function test_updating_a_score_gets_an_error_if_unauthenticated()
    {
        $score = Score::factory()->create();

        $response = $this->putJson(route('games.update', $score), []);

        $response->assertUnauthorized();
    }

    public function test_it_deletes_a_score()
    {
        $player = $this->signIn();

        $score = Score::factory()->for($player)->create();

        $response = $this->deleteJson(route('scores.destroy', $score));

        $response->assertNoContent();

        $this->assertSoftDeleted($score);
    }

    public function test_calling_score_gets_an_error_if_deleted()
    {
        $player = $this->signIn();

        $score = Score::factory()->for($player)->create();

        $score->delete();

        $response = $this->getJson(route('scores.show', $score));

        $response->assertNotFound();
    }

    public function test_delete_game_gets_an_error_if_score_dont_belong_to_the_user()
    {
        $this->signIn();

        $player2 = User::factory()->has(Role::factory()->player())->create();

        $score = Score::factory()->for($player2)->create();

        $response = $this->deleteJson(route('scores.destroy', $score));

        $response->assertForbidden();
    }

    public function test_delete_game_gets_an_error_if_unauthenticated()
    {
        $score = Score::factory()->create();

        $response = $this->deleteJson(route('scores.destroy', $score));

        $response->assertUnauthorized();
    }
}
