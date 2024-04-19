<?php

namespace App\Http\Resources\Shop;

use Illuminate\Http\Request;
use App\Models\ShopLocation;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ShopLocation */
final class ShopLocationTransformer extends JsonResource
{
    public function __construct(ShopLocation $resource) { parent::__construct($resource); }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "location_uuid"        => $this->location_uuid,
            "location_postal_code" => $this->shop_postal_code,
            "location_prefecture"  => $this->shop_prefecture,
            "location_address"     => $this->shop_address,
            "location_building"    => $this->shop_building_number,
        ];
    }
}
