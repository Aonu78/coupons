<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserTransformer;
use App\DataTransfer\User\UpdatePasswordDTO;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Http\Requests\Api\User\UpdatePasswordRequest;

final class ProfileController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function update(UpdateProfileRequest $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $updatedUser = $this->userService->update($user, $request->getDTO());

        return $response->success(
            new UserTransformer($updatedUser),
            trans("user.profile_updated")
        );
    }

    public function updatePassword(UpdatePasswordRequest $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $dto = $request->getDTO();

        if ($this->userService->verifyPassword($user, $dto->oldPassword) === false) {
            return $response->error(trans('user.invalid_old_passwords'));
        }

        $updatedUser = $this->userService->updatePassword($user, $dto->newPassword);

        return $response->success(
            new UserTransformer($updatedUser),
            trans('user.password_updated')
        );
    }

    public function destroy()
    {
        /** @var User $user */
        $user = Auth::user();
        $this->userService->destroy($user);

        return response()->json();
    }
    public function updatePointsAndCPTokens(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'points' => 'required',
            'cp_token_balance' => 'required',
        ]);
        $user->update([
            'points' => $request->points,
            'cp_token_balance' => $request->cp_token_balance,
        ]);
        return response()->json(['message' => 'Points and CPTokens updated successfully','user' => $user]);
    }
}
