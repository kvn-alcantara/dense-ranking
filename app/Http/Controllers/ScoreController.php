<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScoreRequest;
use App\Http\Requests\UpdateScoreRequest;
use App\Http\Resources\ScoreCollection;
use App\Http\Resources\ScoreResource;
use App\Models\Game;
use App\Models\Score;
use Symfony\Component\HttpFoundation\Response;

class ScoreController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Score::class, 'score');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Game $game
     * @return ScoreCollection
     */
    public function index(Game $game): ScoreCollection
    {
        $scores = $game->scores()->paginate();

        return new ScoreCollection($scores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Game $game
     * @param StoreScoreRequest $request
     * @return ScoreResource
     */
    public function store(Game $game, StoreScoreRequest $request): ScoreResource
    {
        $score = $game->scores()->create($request->validated());

        return new ScoreResource($score);
    }

    /**
     * Display the specified resource.
     *
     * @param Score $score
     * @return ScoreResource
     */
    public function show(Score $score): ScoreResource
    {
        return new ScoreResource($score);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateScoreRequest $request
     * @param Score $score
     * @return ScoreResource
     */
    public function update(UpdateScoreRequest $request, Score $score): ScoreResource
    {
        $score->update($request->validated());

        return new ScoreResource($score);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Score $score
     * @return Response
     */
    public function destroy(Score $score): Response
    {
        $score->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
