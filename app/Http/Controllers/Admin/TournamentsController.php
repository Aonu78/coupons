<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Services\GameService;
use App\Services\TournamentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Enum\Tournaments\TournamentFinishingTrigger;

final class TournamentsController extends Controller
{
    public function __construct(
        private readonly GameService $gameService,
        private readonly TournamentService $tournamentService
    ) {}

    public function index()
    {
        $tournaments = $this->tournamentService->all();

        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function details(string $id)
    {
        $tournament = $this->tournamentService->find($id);

        if (is_null($tournament)) {
            return back();
        }

        return view('admin.tournaments.show', compact('tournament'));
    }

    public function create()
    {
        $games = Game::whereGameVisible(true)->get();

        return view('admin.tournaments.create', compact('games'));
    }

    public function save(Request $request): RedirectResponse
    {
        $game = $this->gameService->find($request->input('game'));

        $tournament = $this->tournamentService->create(
            $game,
            TournamentFinishingTrigger::tryFrom($request->input('finishing_trigger'))
        );

        return redirect()->route('admin.tournaments.details', $tournament->tournament_uuid);
    }
}
