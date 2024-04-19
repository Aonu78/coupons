<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\User\SaveUserBankRequest;
use App\Http\Resources\User\BankAccountTransformer;

final class UsersBankController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function getBank(ApiResponse $response): JsonResponse
    {
        /** @var User $user*/
        $user = Auth::user();

        $bank = $this->userService->getUserBank($user);

        return $response->success(
            isset($bank) ? new BankAccountTransformer($bank) : []
        );
    }

    public function save(SaveUserBankRequest $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user*/
        $user = Auth::user();

        $bank = $this->userService->getUserBank($user);

        if (is_null($bank)) {
            $bank = $this->userService->createUserBank($user, $request->getDTO());
        } else {
            $bank = $this->userService->updateBank($bank, $request->getDTO());
        }

        return $response->success(
            new BankAccountTransformer($bank),
            trans('user.bank_details_updated')
        );
    }
}
