<?php

namespace App\Http\Resources\Shop;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Shop */
final class UserShopTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "shop_uuid"          => $this->shop_uuid,
            "shop_name"          => $this->shop_name,
            "shop_name_furigana" => $this->shop_name_furigana,
            "shop_logo"          => $this->logo,
            "shop_pr"            => $this->shop_pr,
            "shop_contact"       => new ShopContactTransformer($this->contact),
            "shop_location"      => new ShopLocationTransformer($this->location),
        ];
    }
}
