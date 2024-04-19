<?php

namespace App\Services;

use App\Models\Game;

final class GameService
{
    public function __construct(
        private readonly Game $gameModel
    ) {}

    public function find(string $id): ?Game
    {
        $query = $this->gameModel->newQuery();

        return $query->where("game_uuid", $id)->first();
    }
}
