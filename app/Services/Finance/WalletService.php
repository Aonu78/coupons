<?php

namespace App\Services\Finance;

use App\ValueObject\Money;
use Illuminate\Support\Str;
use App\Models\Finance\Wallet;
use App\Enum\Finance\WalletCurrency;
use App\Contracts\WalletHolderContract;

final class WalletService
{
    public function __construct(
        private readonly Wallet $walletModel
    ) {}

    public function create(
        WalletHolderContract $walletHolder,
        WalletCurrency $walletCurrency = WalletCurrency::USD,
        float $initialBalance = 0
    ): Wallet {
        /** @var Wallet $wallet */
        $wallet = $walletHolder->wallets()->create([
            "wallet_uuid"     => Str::uuid(),
            "wallet_currency" => $walletCurrency,
            "wallet_balance"  => $initialBalance
        ]);

        return $wallet;
    }

    public function debitWallet(Wallet $wallet, Money $amount): Wallet
    {
        $wallet->wallet_balance->add($amount);
        $wallet->save();

        return $wallet;
    }

    public function creditWallet(Wallet $wallet, Money $amount): Wallet
    {
        $wallet->wallet_balance->sub($amount);
        $wallet->save();

        return $wallet;
    }
}
