<?php

namespace App\Http\Resources\Shop;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Location */
final class LocationTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "location_id"          => $this->location_uuid,
            "location_postal_code" => $this->location_postal_code,
            "location_prefecture"  => $this->location_prefecture,
            "location_city"        => $this->location_city,
            "location_address"     => $this->location_address
        ];
    }
}
