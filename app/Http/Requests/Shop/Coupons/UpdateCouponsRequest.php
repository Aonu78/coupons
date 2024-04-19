<?php

namespace App\Http\Requests\Shop\Coupons;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\Coupons\UpdateCouponDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class UpdateCouponsRequest extends BaseRequest
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
            "coupon_image"            => "sometimes|required|string|nullable",
            "coupon_rebuyible"        => "sometimes|required|nullable|boolean",
            "coupons_available"       => "sometimes|required|nullable|numeric",
            "coupon_description"      => "sometimes|required|nullable|string",
            "game_id"                 => "sometimes|required|nullable|string",
        ];
    }

    public function getDTO(): UpdateCouponDTO
    {
        return new UpdateCouponDTO(
            $this->str("coupon_name"),
            $this->float("coupon_price"),
            $this->str("coupon_sale_start_date"),
            $this->str("coupon_sale_end_date"),
            $this->str("coupon_usage_start_date"),
            $this->str("coupon_usage_end_date"),
            $this->input("coupon_image"),
            $this->boolean("coupon_rebuyible", true),
            $this->input("coupons_available"),
            $this->input("coupon_description"),
            $this->input("game_id"),
        );
    }
}
