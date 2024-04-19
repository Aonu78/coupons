<?php

namespace App\Enum\Tournaments;

enum TournamentType: string
{
    case HEAD_TO_HEAD = "head_to_head";
    case MULTIPLAYER = "multiplayer";
}
