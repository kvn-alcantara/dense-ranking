<?php

namespace App\Observers;

use App\Models\Game;
use Illuminate\Support\Facades\Cache;

class GameObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Game "created" event.
     *
     * @param Game $game
     * @return void
     */
    public function created(Game $game)
    {
        Cache::forget("game-$game->id");
    }

    /**
     * Handle the Game "updated" event.
     *
     * @param Game $game
     * @return void
     */
    public function updated(Game $game)
    {
        Cache::forget("game-$game->id");
    }

    /**
     * Handle the Game "deleted" event.
     *
     * @param Game $game
     * @return void
     */
    public function deleted(Game $game)
    {
        Cache::forget("game-$game->id");
    }

    /**
     * Handle the Game "restored" event.
     *
     * @param Game $game
     * @return void
     */
    public function restored(Game $game)
    {
        Cache::forget("game-$game->id");
    }

    /**
     * Handle the Game "force deleted" event.
     *
     * @param Game $game
     * @return void
     */
    public function forceDeleted(Game $game)
    {
        Cache::forget("game-$game->id");
    }
}
