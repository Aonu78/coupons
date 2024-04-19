<?php

namespace App\Enum\Tournaments;

enum TournamentStatus: string
{
    case MATCHMAKING = "matchmaking";
    case IN_PROGRESS = "in_progress";
    case FINISHED = "finished";

    public function title(): string
    {
        return match ($this) {
            self::MATCHMAKING => trans('tournaments.tournament_status.matchmaking'),
            self::IN_PROGRESS => trans('tournaments.tournament_status.in_progress'),
            self::FINISHED => trans('tournaments.tournament_status.finished'),
        };
    }
}
