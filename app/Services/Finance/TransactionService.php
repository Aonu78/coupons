<?php

namespace App\Services\Finance;

use App\Models\User;
use App\ValueObject\Money;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Finance\Wallet;
use Illuminate\Support\Facades\DB;
use App\Enum\Finance\WalletCurrency;
use App\Contracts\HasTransactionContract;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Finance\Transaction\TransactionStatus;
use App\Enum\Finance\Transaction\TransactionProvider;
use App\Enum\Finance\Transaction\TransactionOperation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TransactionService
{
    public function __construct(
        private readonly WalletService $walletService,
        private readonly Transaction $transactionModel
    ) {}

    public function execute(
        Money $money,
        HasTransactionContract $transactionCreator,
        ?Wallet $executableWallet,
        TransactionOperation $operation,
        TransactionType $type,
        string $description
    ): Transaction {
        return DB::transaction(function () use (
            $money,
            $transactionCreator,
            $executableWallet,
            $operation,
            $type,
            $description
        ) {
            if ($operation === TransactionOperation::DEBIT) {
                $this->walletService->debitWallet($executableWallet, $money);
            } else {
                $this->walletService->creditWallet($executableWallet, $money);
            }

            $objTransaction = $this->transactionModel->newInstance();

            $objTransaction->entity()->associate($transactionCreator);

            $objTransaction->transaction_uuid = Str::uuid();
            $objTransaction->transaction_amount = $money;
            $objTransaction->transaction_description = $description;
            $objTransaction->transaction_operation = $operation;
            $objTransaction->transaction_type = $type;
            $objTransaction->transaction_provider = TransactionProvider::STRIPE;
            $objTransaction->transaction_status = TransactionStatus::SUCCESS;
            $objTransaction->transaction_currency = $executableWallet->wallet_currency;

            $objTransaction->save();

            return $objTransaction;
        });
    }

    public function getHolderTransactions(HasTransactionContract $transactionHolder): LengthAwarePaginator
    {
        return $transactionHolder->transactions()->paginate();
    }

    public function getHolderTransactionsByCurrency(
        HasTransactionContract $transactionHolder,
        WalletCurrency $currency
    ): LengthAwarePaginator {
        return $transactionHolder->transactions()->where("transaction_currency", $currency->value)->paginate();
    }
}
