<?php

namespace App\Constants;

class TransactionDescriptions
{
    const DEPOSIT = "%s$ was added to your wallet.";
    const OPEN_BALANCE = "Opening balance added to your wallet.";

    const WITHDRAW_REQUEST = "Withdraw Request for %s$.";
    const WITHDRAW_ROLLBACK = "Rejected Withdraw Rollback for %s.";

    const ESPORTS_DEBIT = "%s (Esports) game entry fee.";
    const ESPORTS_LEFT = "Leave %s (Esports) game refund.";
    const ESPORTS_WIN = "Win %s (Esports) game reward.";

    const GAME_DEBIT = "%s tournament entry fee.";

    const GAME_WIN = "Win %s tournament game reward";
}
