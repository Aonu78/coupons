<?php

namespace App\Enum\Finance\Transaction;

enum TransactionType: string
{
    case DEPOSIT = "deposit";
    case WITHDRAW = "withdraw";
    case AFFILIATION = "affiliation";
    case GAME = "game";
}
