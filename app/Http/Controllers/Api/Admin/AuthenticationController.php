<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Enum\Users\UserType;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserTransformer;
use App\Http\Requests\Api\User\LoginRequest;
use Illuminate\Validation\ValidationException;

final class AuthenticationController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request, ApiResponse $response): JsonResponse
    {
        $user = $this->userService->findByLogin($request->str("email"));

        if (is_null($user) || $user->user_type !== UserType::ADMIN->value) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $response->success(
            new UserTransformer($user),
            meta: ["token" => $token]
        );
    }
}
