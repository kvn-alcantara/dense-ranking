<?php

namespace App\Listeners;

use App\Events\ScoreModified;
use App\Models\Score;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdjustGameRanking
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ScoreModified $event
     * @return void
     */
    public function handle(ScoreModified $event)
    {
        // Get the existing score with a value higher or equal than the new one
        $existingScore = Score::where('game_id', $event->score->game_id)
            ->where('value', '>=', $event->score->value)
            ->orderBy('value')
            ->first();

        if (is_null($existingScore)) {
            $event->score->position = 1;

            // Increases the position of the lowest value scores
            Score::where('game_id', $event->score->game_id)
                ->where('value', '<', $event->score->value)
                ->increment('position');
        } elseif ($existingScore->value == $event->score->value) {
            $event->score->position = $existingScore->position;
        } elseif ($existingScore->value > $event->score->value) {
            $event->score->position = $existingScore->position + 1;

            // Increases the position of the lowest value scores
            Score::where('game_id', $event->score->game_id)
                ->where('value', '<', $event->score->value)
                ->increment('position');
        }
    }
}
