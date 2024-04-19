<?php

namespace App\DataTransfer\User;

final class SendOtpDTO
{
    public function __construct(
        public readonly string $login
    ) {}
}
