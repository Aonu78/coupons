<?php

namespace App\Traits;


use App\Models\Finance\Wallet;
use App\Enum\Finance\WalletCurrency;
use App\Services\Finance\WalletService;
use Illuminate\Contracts\Container\BindingResolutionException;

trait HasWallet
{
    public function wallets(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Wallet::class, "holder");
    }

    public function createWallet(WalletCurrency $walletCurrency, float $initialBalance = 0): Wallet {
        /** @var WalletService $walletService */
        $walletService = app(WalletService::class);

        return $walletService->create($this, $walletCurrency, $initialBalance);
    }

    public function getWallet(WalletCurrency $walletCurrency): ?Wallet {
        /** @var Wallet $wallet */
        $wallet = $this->wallets()->where("wallet_currency", $walletCurrency->value)->first();

        return $wallet;
    }
}
