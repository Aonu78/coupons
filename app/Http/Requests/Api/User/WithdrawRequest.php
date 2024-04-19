<?php

namespace App\Http\Requests\Api\User;

use App\ValueObject\Money;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use App\DataTransfer\User\Withdraw\CreateWithdrawDTO;

final class WithdrawRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "amount" => "required|numeric|min:10",
        ];
    }

    public function getDTO(): CreateWithdrawDTO
    {
        return new CreateWithdrawDTO(
            new Money($this->float("amount")),
        );
    }
}
