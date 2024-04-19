<?php

namespace App\Http\Requests\Shop\Company;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\DataTransfer\User\Company\SaveCompanyDTO;
use Illuminate\Contracts\Validation\ValidationRule;

final class SaveCompanyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "company_name"          => "required|string",
            "company_address"       => "required|string",
            "company_phone_number"  => "required|string",
            "company_email_address" => "required|string|email",
            "company_sns_account"   => "required|string",
            "company_bank_account"  => "required|string",
        ];
    }

    public function getDTO(): SaveCompanyDTO
    {
        return new SaveCompanyDTO(
            $this->str("company_name"),
            $this->str("company_address"),
            $this->str("company_phone_number"),
            $this->str("company_email_address"),
            $this->str("company_sns_account"),
            $this->str("company_bank_account"),
        );
    }
}
