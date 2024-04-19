<?php

namespace App\Http\Requests\Api\User\Billing;

use App\ValueObject\Money;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\User\Billing\ChargeDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class ChargeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "amount" => "required|numeric|min:10"
        ];
    }

    public function getDTO(): ChargeDTO
    {
        return new ChargeDTO(new Money($this->float("amount")));
    }
}
