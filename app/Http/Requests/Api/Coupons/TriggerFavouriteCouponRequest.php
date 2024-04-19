<?php

namespace App\Http\Requests\Api\Coupons;

use App\Models\Coupon;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class TriggerFavouriteCouponRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "coupon_id" => ["required", Rule::exists(Coupon::class, 'id')]
        ];
    }
}
