<?php

namespace App\Http\Requests\Api\User\Billing;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

final class PaymentMethodRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "payment_method" => "required|string"
        ];
    }
}
