<?php

namespace App\Http\Resources\Coupons;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Games\GamesTransformer;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Shop\UserShopTransformer;

/** @mixin Coupon */
final class CouponsTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        $shop = $this->couponCreator?->shop;

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
            "coupon_can_buy"          => true,
            "coupon_is_favourite"     => $user && $this->isInUserFavourite($user),
            "coupon_associated_game"  => $this->game ? new GamesTransformer($this->game) : null,
            "shop_logo"               => $shop?->logo,
            "shop_details"            => new UserShopTransformer($shop)
        ];
    }
}
