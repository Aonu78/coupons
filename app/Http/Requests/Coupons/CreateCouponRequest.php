<?php

namespace App\Http\Requests\Coupons;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\Coupons\CreateCouponWebDTO;

final class CreateCouponRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
            "coupon_image"            => "required|file|image",
            "coupon_rebuyible"        => "sometimes|required|nullable|boolean",
            "coupons_available"       => "sometimes|required|nullable|numeric",
            "coupon_description"      => "sometimes|required|nullable|string",
        ];
    }


    public function getDTO(): CreateCouponWebDTO
    {
        return new CreateCouponWebDTO(
            $this->str("coupon_name"),
            $this->float("coupon_price"),
            $this->str("coupon_sale_start_date"),
            $this->str("coupon_sale_end_date"),
            $this->str("coupon_usage_start_date"),
            $this->str("coupon_usage_end_date"),
            $this->file("coupon_image"),
            $this->boolean("coupon_rebuyible", true),
            $this->input("coupons_available"),
            $this->input("coupon_description"),
            $this->input("game_id"),
        );
    }
}
