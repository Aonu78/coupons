<?php

namespace App\Http\Resources\Games;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Game */
final class GameDetailsTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "game_id"          => $this->game_uuid,
            "game_name"        => $this->game_name,
            "game_image"       => $this->image,
            "game_description" => $this->game_description,
            "game_rating"      => $this->game_rating,
            "game_join_fee"    => $this->is_free ? 0 : 10,
            "game_free"        => $this->is_free
        ];
    }
}
