<?php

namespace App\Http\Resources\Games;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Game */
final class GamesShortInfoTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "game_id"    => $this->game_uuid,
            "game_name"  => $this->game_name,
            "game_image" => $this->image,
            "game_free"  => $this->is_free
        ];
    }
}
