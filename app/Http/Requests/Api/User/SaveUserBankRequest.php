<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enum\Finance\Bank\DepositType;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\User\BankAccount\SaveBankDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class SaveUserBankRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "bank_name"             => "required|string",
            "branch_number"         => "required|digits:3",
            "deposit_type"          => ["required", new Enum(DepositType::class)],
            "account_name"          => "required|string",
            "account_name_furigana" => "required|string",
            "account_number"        => "required|string",
        ];
    }

    public function getDTO(): SaveBankDTO
    {
        return new SaveBankDTO(
            $this->string("account_name"),
            $this->string("account_name_furigana"),
            $this->string("account_number"),
            $this->string("bank_name"),
            $this->integer("branch_number"),
            DepositType::tryFrom($this->str("deposit_type"))
        );
    }
}
