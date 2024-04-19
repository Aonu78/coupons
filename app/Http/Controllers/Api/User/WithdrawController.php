<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enum\Finance\WalletCurrency;
use App\Enum\Finance\WithdrawStatus;
use App\Services\Finance\WithdrawService;
use App\Http\Requests\Api\User\WithdrawRequest;
use App\Http\Resources\Finance\WithdrawTransformer;

final class WithdrawController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly WithdrawService $withdrawService,
    ) {}

    public function getWithdraws(ApiResponse $apiResponse, ?string $status = null): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $withdrawStatus = null;

        if (is_string($status)) {
            $withdrawStatus = WithdrawStatus::tryFrom($status);

            if (is_null($withdrawStatus)) {
                return $apiResponse->error(trans('withdraw.invalid_status'));
            }
        }

        $withdraws = $this->withdrawService->getWithdraws($user, $withdrawStatus);

        return $apiResponse->success(
            WithdrawTransformer::collection($withdraws),
            meta: ApiResponse::buildPaginationMeta($withdraws)
        );
    }

    /**
     * @throws \Throwable
     */
    public function create(WithdrawRequest $request, ApiResponse $apiResponse): JsonResponse
    {
        /** @var User $user*/
        $user = Auth::user();
        $dto = $request->getDTO();

        $userBank = $this->userService->getUserBank($user);

        if (is_null($userBank)) {
            return  $apiResponse->error(trans('withdraw.empty_bank_details'));
        }

        $usdWallet = $user->getWallet(WalletCurrency::USD);

        if (is_null($usdWallet)) {
            return $apiResponse->error(trans("user.invalid_wallet"));
        }

        if ($usdWallet->wallet_balance->lessThen($dto->amount)) {
            return $apiResponse->error(trans('user.insufficient_balance'));
        }

        $withdraw = $this->withdrawService->create($user, $dto->amount);

        return $apiResponse->success(
            new WithdrawTransformer($withdraw),
            trans("withdraw.success_requested")
        );
    }
}
