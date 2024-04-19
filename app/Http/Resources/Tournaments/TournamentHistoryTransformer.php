<?php

namespace App\Http\Resources\Tournaments;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Http\Resources\Games\GamesTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TournamentPlayerTransformer;

/** @mixin Tournament */
class TournamentHistoryTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $me = $this->getAuthPlayer();

        return [
            "tournament_uuid"        => $this->tournament_uuid,
            "tournament_bet"         => $this->tournament_bet,
            "tournament_win"         => $me->is_winner ? ($this->tournament_bet * $this->players()->count()) : 0,
            "tournament_finished_at" => $this->updated_at,
            "is_winner"              => $me->is_winner,
            "me"                     => is_object($me) ? new TournamentPlayerTransformer($me) : null,
            "game"                   => new GamesTransformer($this->game)
        ];
    }
}
