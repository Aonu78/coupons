<?php

namespace App\DataTransfer\User\Billing;

use App\ValueObject\Money;

final class ChargeDTO
{
    public function __construct(
        public readonly Money $amount
    ) {}
}
