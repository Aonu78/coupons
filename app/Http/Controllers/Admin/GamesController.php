<?php

namespace App\Http\Controllers\Admin;

use App\Services\Game\GameService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Games\EditGameRequest;
use App\Http\Requests\Admin\Games\CreateGameRequest;

final class GamesController extends Controller
{
    public function __construct(
        private readonly GameService $gameService
    ) {}

    public function index()
    {
        $games = $this->gameService->getAllPaginatedGames(false);

        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function save(CreateGameRequest $request): RedirectResponse
    {
        $game = $this->gameService->create($request->getDTO());

        return redirect()->route('admin.games.edit', $game->game_uuid)
            ->with('success', "You have successfully added new game!");
    }

    public function edit(string $id)
    {
        $game = $this->gameService->findGame($id);

        if (is_null($game)) {
            return redirect()->route('admin.games.index');
        }

        return view('admin.games.edit', compact('game'));
    }

    public function update(string $id, EditGameRequest $request)
    {
        $game = $this->gameService->findGame($id);

        if (is_null($game)) {
            return redirect()->route('admin.games.index');
        }

        $this->gameService->updateGame($game, $request->getDTO());

        return redirect()->route('admin.games.edit', $game->game_uuid)
            ->with('success', 'You have successfully updated the game.');
    }
}
