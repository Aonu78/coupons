<?php

namespace App\Http\Requests\Api\Coupons;

use App\Models\Coupon;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\DataTransfer\Coupons\BuyCouponDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class BuyCouponRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "coupon_id" => ["required", Rule::exists(Coupon::class, 'id')],
            "payment_method" => ["required", "string"]
        ];
    }

    public function getDTO(): BuyCouponDTO
    {
        return new BuyCouponDTO(
            $this->integer("coupon_id"),
            $this->string("payment_method")
        );
    }
}
