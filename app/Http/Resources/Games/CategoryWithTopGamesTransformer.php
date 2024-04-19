<?php

namespace App\Http\Resources\Games;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\Games\Category;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */
final class CategoryWithTopGamesTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $games = $this->getTopCategoryGames();

        return [
            "category_id"    => $this->category_uuid,
            "category_name"  => $this->name,
            "category_games" => GamesTransformer::collection($games)
        ];
    }
}
