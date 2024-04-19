<?php

namespace App\Http\Controllers\Api\Game;

use App\Models\Game;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\Game\GameService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Games\GamesTransformer;
use App\Http\Resources\Games\GameDetailsTransformer;
use App\Http\Resources\Games\GamesShortInfoTransformer;
use App\Http\Resources\Games\CategoryWithGamesTransformer;
use App\Http\Resources\Games\CategoryWithTopGamesTransformer;

final class GamesController extends Controller
{
    public function __construct(
        private readonly GameService $gameService
    ) {}

    public function getCategories(Request $request, ApiResponse $response): JsonResponse
    {
        $categories = $this->gameService->getCategories();

        return $response->success(
            CategoryWithTopGamesTransformer::collection($categories),
            trans("games.success_get_categories"),
            [ "image" => "https://couprize.s3.eu-central-1.amazonaws.com/images/398336screen_1024x500_2021-08-04_10-09-31.png" ]
        );
    }

    public function findCategory(string $id, ApiResponse $response): JsonResponse
    {
        $category = $this->gameService->findCategory($id);

        if (is_null($category)) {
            return $response->error(trans("games.category_not_found"));
        }

        return $response->success(
            new CategoryWithGamesTransformer($category),
            meta: ["image" => "https://couprize.s3.eu-central-1.amazonaws.com/images/398336screen_1024x500_2021-08-04_10-09-31.png"]
        );
    }

    public function getAllPaginatedGames(Request $request, ApiResponse $response): JsonResponse
    {
        if ($request->has("game_name")) {
            $games = $this->gameService->searchGame($request->str("game_name"));
        } else {
            $games = $this->gameService->getAllPaginatedGames();
        }

        return $response->success(
            GamesTransformer::collection($games),
            meta: ApiResponse::buildPaginationMeta($games)
        );
    }

    public function getAllGames(ApiResponse $response): JsonResponse
    {
        $games = $this->gameService->getAllGames();

        return $response->success(GamesShortInfoTransformer::collection($games));
    }


    public function findGame(string $game, ApiResponse $response): JsonResponse
    {
        $game = $this->gameService->findGame($game);

        if (is_null($game)) {
            return $response->error(trans('games.not_found'));
        }

        return $response->success(new GameDetailsTransformer($game));
    }
}
