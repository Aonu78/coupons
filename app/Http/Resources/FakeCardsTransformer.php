<?php

namespace App\Http\Resources;

use App\Models\FakeCards;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FakeCards */
class FakeCardsTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "card_id"           => $this->id,
            "card_number_last4" => substr(decrypt($this->card_number), -4),
            "card_exp_month"    => $this->card_exp_month,
            "card_exp_year"     => $this->card_exp_year,
        ];
    }
}
