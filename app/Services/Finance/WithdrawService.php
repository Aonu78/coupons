<?php

namespace App\Services\Finance;

use App\ValueObject\Money;
use Illuminate\Support\Str;
use App\Models\Finance\Withdraw;
use Laravel\Cashier\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Enum\Finance\WithdrawStatus;
use App\Enum\Finance\WalletCurrency;
use App\Contracts\HasWithdrawContract;
use App\Constants\TransactionDescriptions;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Finance\Transaction\TransactionOperation;

final class WithdrawService
{
    public function __construct(
        private readonly TransactionService $transactionService,
        //Models
        private readonly Withdraw $withdrawModel
    ) {}

    /**
     * @throws \Throwable
     */
    public function create(
        HasWithdrawContract $withdrawOwner,
        Money $money,
        ?PaymentMethod $withdrawTarget = null
    ): Withdraw
    {
        return DB::transaction(function () use ($withdrawOwner, $money, $withdrawTarget) {
            $withdraw = $this->withdrawModel->newInstance();

            $withdraw->entity()->associate($withdrawOwner);
            $withdraw->withdraw_uuid = Str::uuid();
            $withdraw->withdraw_status = WithdrawStatus::PENDING;
            $withdraw->withdraw_history_amount = $money;
            $withdraw->withdraw_target = null;

            $withdraw->save();

            $withdraw->createWallet(WalletCurrency::USD);

            $this->transactionService->execute(
                $money,
                $withdrawOwner,
                $withdrawOwner->getWallet(WalletCurrency::USD),
                TransactionOperation::CREDIT,
                TransactionType::WITHDRAW,
                sprintf(TransactionDescriptions::WITHDRAW_REQUEST, $money->getAmountString())
            );

            $this->transactionService->execute(
                $money,
                $withdraw,
                $withdraw->getWallet(WalletCurrency::USD),
                TransactionOperation::DEBIT,
                TransactionType::WITHDRAW,
                sprintf(TransactionDescriptions::WITHDRAW_REQUEST, $money->getAmountString())
            );

            return $withdraw;
        });
    }

    /**
     * @param HasWithdrawContract $withdrawOwner
     * @param WithdrawStatus|null $withdrawStatus
     * @return LengthAwarePaginator
     */
    public function getWithdraws(HasWithdrawContract $withdrawOwner, ?WithdrawStatus $withdrawStatus = null): LengthAwarePaginator
    {
        $objQuery = $withdrawOwner->withdraws()->getQuery();

        if (!is_null($withdrawStatus)) {
            $objQuery->where("withdraw_status", $withdrawStatus->value);
        }

        return $objQuery->latest()->paginate();
    }

    public function getAll(): LengthAwarePaginator
    {
        $query = $this->withdrawModel->newQuery();

        return $query->latest()->paginate();
    }

    public function find(string $id): ?Withdraw
    {
        $query = $this->withdrawModel->newQuery();

        /** @var ?Withdraw $withdraw */
        $withdraw = $query->where('withdraw_uuid', $id)->first();

        return $withdraw;
    }

    public function updateStatus(Withdraw $withdraw, WithdrawStatus $withdrawStatus): Withdraw
    {
        $withdraw->withdraw_status = $withdrawStatus;
        $withdraw->save();

        return $withdraw;
    }
}
