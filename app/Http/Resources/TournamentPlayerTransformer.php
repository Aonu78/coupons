<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\TournamentPlayers;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TournamentPlayers */
class TournamentPlayerTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "player_uuid"   => $this->player_uuid,
            "player_name"   => $this->user->name,
            "player_score"  => $this->player_score,
            "player_status" => $this->player_status->value,
            "player_avatar" => "https://gmembers.s3.eu-central-1.amazonaws.com/user/3/avatar.png?nocache=1697048336",
            "is_winner"     => $this->is_winner
        ];
    }
}
