<?php

namespace App\DataTransfer\User;

final class UpdatePasswordDTO
{
    public function __construct(
        public readonly string $oldPassword,
        public readonly string $newPassword
    ) {}
}
