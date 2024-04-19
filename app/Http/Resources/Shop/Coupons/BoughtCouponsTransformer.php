<?php

namespace App\Http\Resources\Shop\Coupons;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Resources\Games\GamesTransformer;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Coupon */
final class BoughtCouponsTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shopImage = $this->couponCreator?->shop?->logo;

        return [
            "coupon_id"               => $this->id,
            "coupon_name"             => $this->name,
            "coupon_description"      => $this->coupon_description,
            "coupon_price"            => $this->price,
            "coupon_sale_start_date"  => $this->sale_start_date,
            "coupon_sale_end_date"    => $this->sale_end_date,
            "coupon_usage_start_date" => $this->coupon_usage_start_date,
            "coupon_usage_end_date"   => $this->coupon_usage_end_date,
            "coupon_image"            => $this->image,
            "coupons_available"       => $this->coupons_available,
            "coupon_rebuyible"        => $this->coupon_rebuyible,
            "coupon_associated_game"  => $this->game ? new GamesTransformer($this->game) : null,
            "shop_logo"               => $shopImage,
            "coupon_bought_times"     => $this->users_count
        ];
    }
}
