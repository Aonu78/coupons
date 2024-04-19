<?php

namespace App\Enum\Tournaments\Players;

enum PlayerStatus: string
{
    case MATCHMAKING = "matchmaking";
    case IN_GAME = "in_game";
    case GAME_FINISHED = "game_finished";
    case LEAVED = "leaved";
    case TOURNAMENT_FINISHED = "tournament_finished";

    public function title(): string
    {
        return match ($this) {
            self::MATCHMAKING => trans('tournaments.player_status.matchmaking'),
            self::IN_GAME => trans('tournaments.player_status.in_game'),
            self::LEAVED => trans('tournaments.player_status.leaved'),
            default => trans('tournaments.player_status.finished'),
        };
    }
}
