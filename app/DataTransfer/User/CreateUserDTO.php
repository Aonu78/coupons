<?php

namespace App\DataTransfer\User;

use App\Enum\Users\UserType;

final class CreateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly UserType $userType,
        public readonly ?string $phoneNumber = null,
        public readonly ?string $inviteCode = null,
        public readonly ?string $referral_code = null
    ) {}
}
