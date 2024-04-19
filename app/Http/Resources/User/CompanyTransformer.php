<?php

namespace App\Http\Resources\User;

use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UserCompany */
final class CompanyTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "company_name"          => $this->company_name,
            "company_address"       => $this->address,
            "company_phone_number"  => $this->telephone_number,
            "company_email_address" => $this->email_address,
            "company_sns_account"   => $this->sns_account,
            "company_bank_account"  => $this->bank_account_information,
        ];
    }
}
