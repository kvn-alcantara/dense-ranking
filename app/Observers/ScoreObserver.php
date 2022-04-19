<?php

namespace App\Observers;

use App\Models\Score;
use Illuminate\Support\Facades\Cache;

class ScoreObserver
{
    /**
     * Handle the Score "created" event.
     *
     * @param Score $score
     * @return void
     */
    public function created(Score $score)
    {
        // Get the existing score with a value higher or equal than the new one
        $existingScore = Score::where('game_id', $score->game_id)
            ->where('value', '>=', $score->value)
            ->orderBy('value')
            ->limit(1)
            ->get();

        if (is_null($existingScore)) {
            $score->position = 1;
        } elseif ($existingScore->value === $score->value) {
            $score->position = $existingScore->position;
        } elseif ($existingScore->value > $score->value) {
            $score->position = $existingScore->position + 1;

            // Increases the position of the lowest value scores
            Score::where('game_id', $score->game_id)
                ->where('value', '<', $score->value)
                ->increment('position');
        }

        Cache::forget("score-$score->id");
    }

    /**
     * Handle the Score "updated" event.
     *
     * @param Score $score
     * @return void
     */
    public function updated(Score $score)
    {
        Cache::forget("score-$score->id");
    }

    /**
     * Handle the Score "deleted" event.
     *
     * @param Score $score
     * @return void
     */
    public function deleted(Score $score)
    {
        Cache::forget("score-$score->id");
    }

    /**
     * Handle the Score "restored" event.
     *
     * @param Score $score
     * @return void
     */
    public function restored(Score $score)
    {
        Cache::forget("score-$score->id");
    }

    /**
     * Handle the Score "force deleted" event.
     *
     * @param Score $score
     * @return void
     */
    public function forceDeleted(Score $score)
    {
        Cache::forget("score-$score->id");
    }
}
