<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\UserCompany;
use App\DataTransfer\User\Company\SaveCompanyDTO;

final class CompanyService
{
    public function __construct(
        private readonly UserCompany $userCompanyModel
    ) {}

    public function getUserCompany(User $user): ?UserCompany
    {
        return $user->company;
    }

    public function save(User $user, SaveCompanyDTO $companyDTO): UserCompany
    {
        return UserCompany::updateOrCreate(['user_id' => $user->id], [
            'company_name'             => $companyDTO->name,
            'address'                  => $companyDTO->address,
            'telephone_number'         => $companyDTO->phoneNumber,
            'email_address'            => $companyDTO->emailAddress,
            'sns_account'              => $companyDTO->sns,
            'bank_account_information' => $companyDTO->bank,
        ]);
    }
}
