<?php

namespace App\Http\Resources\Shop;

use App\Models\ShopContact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ShopContact */
final class ShopContactTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "contact_uuid"          => $this->contact_uuid,
            "contact_name"          => $this->contact_name,
            "contact_name_furigana" => $this->contact_name_furigana,
            "contact_phone_number"  => $this->contact_phone_number,
            "contact_url"           => $this->shop_url,
        ];
    }
}
