<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Throwable;

class GameService
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $game = Game::create($data);

            if (array_key_exists('scores', $data)) {
                foreach ($data['scores'] as $score) {
                    // user_id can be null, it will appear as "anonymous" in the ranking
                    $game->scores()->create($score);
                }
            }

            $game->load('scores.user');

            return $game;
        });
    }
}
