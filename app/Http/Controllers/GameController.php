<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GameController extends Controller
{
    /**
     * The game service implementation.
     *
     * @var GameService
     */
    protected $gameService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(GameService $gameService)
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Game::class, 'game');
        $this->gameService = $gameService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return GameCollection
     */
    public function index(): GameCollection
    {
        $games = Game::paginate();

        return new GameCollection($games);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return GameResource
     * @throws Throwable
     */
    public function store(StoreGameRequest $request): GameResource
    {
        $game = $this->gameService->store($request->validated());

        return new GameResource($game);
    }

    /**
     * Display the specified resource.
     *
     * @param Game $game
     * @return GameResource
     */
    public function show(Game $game): GameResource
    {
        $game->loadMissing('scores.user');

        return new GameResource($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGameRequest $request
     * @param Game $game
     * @return GameResource
     */
    public function update(UpdateGameRequest $request, Game $game): GameResource
    {
        $game->update($request->validated());

        $game->loadMissing('scores.user');

        return new GameResource($game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Game $game
     * @return JsonResponse
     */
    public function destroy(Game $game): JsonResponse
    {
        $game->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
