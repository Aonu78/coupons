<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Support\Http\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enum\Finance\WalletCurrency;
use App\Services\Finance\TransactionService;
use App\Http\Resources\Finance\TransactionTransformer;

class TransactionsController extends Controller
{
    public function __construct(private readonly TransactionService $transactionService) {}

    public function getTransactions(ApiResponse $response)
    {
        /** @var User $user */
        $user = Auth::user();

        $transactions = $this->transactionService->getHolderTransactions($user);

        return $response->success(
            TransactionTransformer::collection($transactions),
            meta: ApiResponse::buildPaginationMeta($transactions)
        );
    }

    public function getUsdTransactions(ApiResponse $response)
    {
        /** @var User $user */
        $user = Auth::user();

        $transactions = $this->transactionService->getHolderTransactionsByCurrency($user, WalletCurrency::USD);

        return $response->success(
            TransactionTransformer::collection($transactions),
            meta: ApiResponse::buildPaginationMeta($transactions)
        );
    }

    public function getCPTransactions(ApiResponse $response)
    {
        /** @var User $user */
        $user = Auth::user();

        $transactions = $this->transactionService->getHolderTransactionsByCurrency($user, WalletCurrency::CP_TOKEN);

        return $response->success(
            TransactionTransformer::collection($transactions),
            meta: ApiResponse::buildPaginationMeta($transactions)
        );
    }
}
