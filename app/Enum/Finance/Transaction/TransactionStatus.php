<?php

namespace App\Enum\Finance\Transaction;

enum TransactionStatus: string
{
    case PENDING = "pending";
    case SUCCESS = "success";
    case FAILED = "failed";
}
