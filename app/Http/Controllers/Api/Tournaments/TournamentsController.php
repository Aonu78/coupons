<?php

namespace App\Http\Controllers\Api\Tournaments;

use App\Models\User;
use App\Enum\Users\UserType;
use App\Services\GameService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Support\Http\ApiResponse;
use App\Services\TournamentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TournamentTransformer;
use App\Enum\Tournaments\Players\PlayerStatus;
use App\Http\Resources\TournamentListTransformer;
use App\Http\Requests\Api\Tournaments\JoinRequest;
use App\Enum\Tournaments\TournamentFinishingTrigger;
use App\Http\Resources\Tournaments\TournamentHistoryTransformer;

final class TournamentsController extends Controller
{
    public function __construct(
        private readonly GameService $gameService,
        private readonly TournamentService $tournamentService
    ) {}

    public function getTournament(string $id): JsonResponse
    {
        $tournament = $this->tournamentService->find($id);

        if (is_null($tournament)) {
            return response()->json([
                "message" => trans('tournaments.not_found')
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            "data" => new TournamentTransformer($tournament)
        ]);
    }

    public function getActiveTournament(Request $request): JsonResponse
    {
        $game = $this->gameService->find($request->input('game_id'));

        if (is_null($game)) {
            return response()->json([
                "message" => trans('games.not_found')
            ], Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user*/
        $user = Auth::user();

        $tournaments = $this->tournamentService->getActiveTournaments($game, $user);

        return response()->json([
            "data" => TournamentListTransformer::collection($tournaments)
        ]);
    }

    public function getTournamentHistory(Request $request): JsonResponse
    {
        $game = $this->gameService->find($request->input('game_id'));

        if (is_null($game)) {
            return response()->json([
                "message" => trans('games.not_found')
            ], Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user*/
        $user = Auth::user();

        $tournaments = $this->tournamentService->getUserHistoryByGame($game, $user);

        return response()->json([
            "data" => TournamentListTransformer::collection($tournaments)
        ]);
    }

    public function getAllTournamentHistory(ApiResponse $response): JsonResponse
    {
        /** @var User $user*/
        $user = Auth::user();

        $tournaments = $this->tournamentService->getUserHistory($user);
        $winningSum = $this->tournamentService->calculateUserWinning($user);

        return $response->success(
            TournamentHistoryTransformer::collection($tournaments),
            meta: array_merge(ApiResponse::buildPaginationMeta($tournaments), [
                "tournaments_winning_sum" => $winningSum
            ])
        );
    }

    public function createTournament(Request $request)
    {
        $game = $this->gameService->find($request->input('game_id'));

        if (is_null($game)) {
            return response()->json([
                "message" => trans('games.not_found')
            ], Response::HTTP_BAD_REQUEST);
        }

        $finishingTrigger = TournamentFinishingTrigger::tryFrom($request->input('finishing_trigger', 'players_count'));

        $tournament = $this->tournamentService->create($game, $finishingTrigger);

        return response()->json([
            "data" => new TournamentTransformer($tournament)
        ]);
    }
    /**
     * @throws \Exception
     */
    public function join(JoinRequest $request): JsonResponse
    {
        /** @var User $user*/
        $user = Auth::user();

        if ($request->has("tournament_id")) {
            $tournament = $this->tournamentService->find($request->input("tournament_id"));
        } else {
            $game = $this->gameService->find($request->input('game_id'));

            if (is_null($game)) {
                return response()->json([
                    "message" => trans('games.not_found')
                ], Response::HTTP_BAD_REQUEST);
            }

            $tournament = $this->tournamentService->create($game);
        }

        $tournament = $this->tournamentService->join($tournament, $user);

        $bots = User::where('user_type', UserType::BOT->value)->inRandomOrder()->take(4)->get();

        foreach ($bots as $bot) {
            $tournament = $this->tournamentService->join($tournament, $bot);
        }

        $tournament = $tournament->refresh();

        return response()->json([
            "data" => new TournamentTransformer($tournament)
        ]);
    }

    public function startMatch(Request $request)
    {
        $tournament = $this->tournamentService->find($request->string('tournament_id'));

        if (is_null($tournament)) {
            return response()->json([
                "message" => trans('tournaments.not_found')
            ], Response::HTTP_BAD_REQUEST);
        }

        $tournament = $this->tournamentService->startMatch($tournament);

        return response()->json([
            "data" => new TournamentTransformer($tournament->refresh())
        ]);
    }

    /**
     * @throws \Exception
     */
    public function finishMatch(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $tournament = $this->tournamentService->find($request->input('tournament_id'));
        $player = $this->tournamentService->getTournamentPlayer($tournament, $user);

        if (is_null($player)) {
            throw new \Exception(trans("tournaments.not_player"));
        }

        $this->tournamentService->finishMatch($player, $request->float('score'));

        return response()->json(new TournamentTransformer($tournament->refresh()));
    }
}
