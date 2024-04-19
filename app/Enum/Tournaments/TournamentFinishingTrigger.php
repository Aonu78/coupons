<?php

namespace App\Enum\Tournaments;

enum TournamentFinishingTrigger: string
{
    case PLAYERS_COUNT = "players_count";
    case TIME = "time";

    public function title(): string
    {
        return match ($this) {
            self::PLAYERS_COUNT => trans('tournaments.finishing_trigger.players_limit'),
            self::TIME => trans('tournaments.finishing_trigger.time'),
        };
    }
}
