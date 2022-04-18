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
        $this->middleware('auth');
        $this->authorizeResource(Score::class, 'score');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ScoreCollection
     */
    public function index()
    {
        $scores = Score::paginate();

        return new ScoreCollection($scores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreScoreRequest $request
     * @return ScoreResource
     */
    public function store(StoreScoreRequest $request): ScoreResource
    {
        $score = auth()->user()->scores()->create($request->validated());

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
