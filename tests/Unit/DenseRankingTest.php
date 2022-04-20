<?php

namespace Tests\Unit;

use App\Events\ScoreModified;
use App\Listeners\AdjustGameRanking;
use App\Models\Game;
use App\Models\Score;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DenseRankingTest extends TestCase
{
    use RefreshDatabase;

    public function test_score_is_attached_to_event()
    {
        Event::fake();

        Event::assertListening(
            ScoreModified::class,
            AdjustGameRanking::class
        );
    }
}
