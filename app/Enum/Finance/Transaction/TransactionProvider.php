<?php

namespace App\Enum\Finance\Transaction;

enum TransactionProvider: string
{
    case SYSTEM = "system";
    case STRIPE = "stripe";
}
