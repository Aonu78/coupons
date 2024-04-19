<?php

namespace App\Enum\Finance\Bank;

enum DepositType: string
{
    case NORMAL = "normal";
    case CURRENT = "current";

    case SAVING = "saving";
}
