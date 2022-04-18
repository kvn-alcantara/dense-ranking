<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ScoreService
{
    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $game = Game::find($data['game_id']);

            if (array_key_exists('scores', $data)) {
                foreach ($data['scores'] as $score) {
                    // user_id can be null, it will appear as "anonymous" in the ranking
                    $game->scores()->attach($score['user_id'], ['value' => $score['value']]);
                }
            }

            return $game;
        });
    }
}
