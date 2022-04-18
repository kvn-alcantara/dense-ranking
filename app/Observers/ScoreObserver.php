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
