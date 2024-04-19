<?php

namespace App\Http\Resources;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Enum\Tournaments\TournamentType;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enum\Tournaments\TournamentFinishingTrigger;

/** @mixin Tournament */
class TournamentTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $playerLimit = $this->tournament_type === TournamentType::HEAD_TO_HEAD ? 2 : 5;

        $me = $this->getAuthPlayer();
        $winner = $this->getWinner();

        return [
            "tournament_uuid"              => $this->tournament_uuid,
            "tournament_status"            => $this->tournament_status->value,
            "tournament_bet"               => $this->tournament_bet,
            "tournament_finishing_trigger"  => $this->tournament_finishing_trigger->value,
            "tournament_players_limit"     => $this->tournament_finishing_trigger == TournamentFinishingTrigger::PLAYERS_COUNT ?
                $playerLimit :
                null,
            "tournament_slots_left"        => $this->tournament_finishing_trigger == TournamentFinishingTrigger::PLAYERS_COUNT ?
                $playerLimit - $this->players->count() :
                null,
            "tournament_starts_at"         => $this->tournament_starts_at,
            "tournament_ends_at"           => $this->tournament_ends_at,
            "tournament_winner"            => is_object($winner) ? new TournamentPlayerTransformer($winner) : null,
            "me"                           => is_object($me) ? new TournamentPlayerTransformer($me) : null,
            "tournament_players"           => TournamentPlayerTransformer::collection($this->players),
        ];
    }
}
