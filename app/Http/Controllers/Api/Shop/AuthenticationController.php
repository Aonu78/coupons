<?php

namespace App\Http\Controllers\Api\Shop;

use App\Models\User;
use App\Enum\Users\UserType;
use App\Support\Http\ApiResponse;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserTransformer;
use App\Http\Requests\Api\User\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Shop\Auth\RegisterRequest;

final class AuthenticationController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request, ApiResponse $response): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->findByLogin($request->str("email"));

        if (is_null($user) || $user->user_type !== UserType::COMPANY->value) {
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

    /**
     * @throws \Exception
     */
    public function register(RegisterRequest $request, ApiResponse $response): \Illuminate\Http\JsonResponse
    {
        $user = $this->userService->create($request->getDTO());
        $authToken = $this->userService->createToken($user, 'auth_token');

        return $response->success(
            new UserTransformer($user),
            trans('auth.success_registration'),
            ["token" => $authToken]
        );
    }
}
