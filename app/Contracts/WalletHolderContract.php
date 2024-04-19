<?php

namespace App\Contracts;

use App\Models\Finance\Wallet;
use App\Enum\Finance\WalletCurrency;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface WalletHolderContract extends HasTransactionContract
{
    public function wallets(): MorphMany;
    public function createWallet(WalletCurrency $walletCurrency): Wallet;
    public function getWallet(WalletCurrency $walletCurrency): ?Wallet;
}
