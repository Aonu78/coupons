<?php

namespace App\Contracts;

interface HasWithdrawContract extends WalletHolderContract
{
    public function withdraws(): \Illuminate\Database\Eloquent\Relations\MorphMany;
}
