<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Role;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $players = User::factory()
            ->count(15)
            ->has(Role::factory()->player())
            ->create();

        $games = Game::factory()
            ->count(5)
            ->create();

        foreach ($games as $game) {
            foreach ($players as $player) {
                Score::factory()
                    ->for($game)
                    ->for($player)
                    ->create();
            }
        }
    }
}
