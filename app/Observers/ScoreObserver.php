<?php

namespace App\Observers;

use App\Events\ScoreModified;
use App\Models\Score;

class ScoreObserver
{
    /**
     * Handle the Score "created" event.
     *
     * @param Score $score
     * @return void
     */
    public function creating(Score $score)
    {
        ScoreModified::dispatch($score);
    }

    /**
     * Handle the Score "created" event.
     *
     * @param Score $score
     * @return void
     */
    public function created(Score $score)
    {
        //
    }

    /**
     * Handle the Score "updated" event.
     *
     * @param Score $score
     * @return void
     */
    public function updated(Score $score)
    {
        ScoreModified::dispatch($score);
    }

    /**
     * Handle the Score "deleted" event.
     *
     * @param Score $score
     * @return void
     */
    public function deleted(Score $score)
    {
        ScoreModified::dispatch($score);
    }

    /**
     * Handle the Score "restored" event.
     *
     * @param Score $score
     * @return void
     */
    public function restored(Score $score)
    {
        ScoreModified::dispatch($score);
    }

    /**
     * Handle the Score "force deleted" event.
     *
     * @param Score $score
     * @return void
     */
    public function forceDeleted(Score $score)
    {
        ScoreModified::dispatch($score);
    }
}
