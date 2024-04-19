<?php

namespace App\Http\Resources\Shop\Coupons;

use Illuminate\Http\Request;
use App\Models\UsersCoupons;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UsersCoupons */
final class BoughtCouponTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "buyer_name"     => $this->user->name,
            "buyer_email"    => $this->user->email,
            "is_user_before" => !empty($this->used_at),
            "coupon_name"    => $this->coupon->name,
        ];
    }
}
