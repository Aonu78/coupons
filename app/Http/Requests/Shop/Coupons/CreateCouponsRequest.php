<?php

namespace App\Http\Requests\Shop\Coupons;

use App\Http\Requests\BaseRequest;
use App\DataTransfer\Coupons\CreateCouponDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class CreateCouponsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "coupon_name"             => "required|string",
            "coupon_price"            => "required",
            "coupon_sale_start_date"  => "required|string",
            "coupon_sale_end_date"    => "required|string",
            "coupon_usage_start_date" => "required|string",
            "coupon_usage_end_date"   => "required|string",
            "coupon_image"            => "required|string",
            "coupon_rebuyible"        => "sometimes|required|nullable|boolean",
            "coupons_available"       => "sometimes|required|nullable|numeric",
            "coupon_description"      => "sometimes|required|nullable|string",
            "game_id"                 => "sometimes|required|nullable|string",
        ];
    }

    public function getDTO(): CreateCouponDTO
    {
        return new CreateCouponDTO(
            $this->str("coupon_name"),
            $this->float("coupon_price"),
            $this->str("coupon_sale_start_date"),
            $this->str("coupon_sale_end_date"),
            $this->str("coupon_usage_start_date"),
            $this->str("coupon_usage_end_date"),
            $this->str("coupon_image"),
            $this->boolean("coupon_rebuyible", true),
            $this->input("coupons_available"),
            $this->input("coupon_description"),
            $this->input("game_id"),
        );
    }
}
