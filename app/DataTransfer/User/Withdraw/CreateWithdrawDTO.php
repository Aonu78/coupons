<?php

namespace App\DataTransfer\User\Withdraw;

use App\ValueObject\Money;

final class CreateWithdrawDTO
{
    /**
     * @param Money $amount Amount Of Withdrawal Request. Minimum - 10, Maximum - User USD Balance
     */
    public function __construct(
        public readonly Money $amount,
    ) {}
}
