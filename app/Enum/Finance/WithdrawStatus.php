<?php

namespace App\Enum\Finance;

enum WithdrawStatus: string
{
    case PENDING = "pending";
    case ACCEPTED = "accepted";
    case REJECTED = "rejected";

    public function title(): string
    {
        return match ($this) {
            self::PENDING => trans('withdraw.status.pending'),
            self::ACCEPTED => trans('withdraw.status.accepted'),
            self::REJECTED => trans('withdraw.status.rejected')
        };
    }
}
