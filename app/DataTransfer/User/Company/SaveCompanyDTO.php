<?php

namespace App\DataTransfer\User\Company;

final class SaveCompanyDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $address,
        public readonly string $phoneNumber,
        public readonly string $emailAddress,
        public readonly string $sns,
        public readonly string $bank,
    ) {}
}
