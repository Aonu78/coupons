<?php

namespace App\DataTransfer\User\BankAccount;

use App\Enum\Finance\Bank\DepositType;

final class SaveBankDTO
{
    public function __construct(
        public readonly string $accountName,
        public readonly string $accountNameFurigana,
        public readonly string $accountNumber,
        public readonly string $bankName,
        public readonly int $branchNumber,
        public readonly DepositType $depositType,
    ) {}
}
