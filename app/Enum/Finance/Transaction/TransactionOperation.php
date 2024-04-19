<?php

namespace App\Enum\Finance\Transaction;

enum TransactionOperation: string
{
    case DEBIT = "debit";
    case CREDIT = "credit";
}
