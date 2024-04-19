<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Google_Service_Oauth2;
use App\Enum\Users\OtpType;
use Illuminate\Support\Str;
use App\Enum\Users\UserType;
use Illuminate\Http\JsonResponse;
use App\Support\Http\ApiResponse;
use App\Services\User\OtpService;
use Google_Service_PeopleService;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserTransformer;
use Laravel\Socialite\Facades\Socialite;
use App\DataTransfer\User\CreateUserDTO;
use Laravel\Socialite\Two\GoogleProvider;
use App\Http\Requests\Api\User\LoginRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\User\SendOtpRequest;
use App\Http\Requests\Api\User\RegisterRequest;

final class AuthenticationController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly OtpService $otpService
    ) {}

    /**
     * @throws \Exception
     */
    public function register(RegisterRequest $request, ApiResponse $response): JsonResponse
    {
        $user = $this->userService->create($request->getDTO());
        $authToken = $this->userService->createToken($user, 'auth_token');

        return $response->success(
            new UserTransformer($user),
            trans('auth.success_registration'),
            ["token" => $authToken]
        );
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "data"  => new UserTransformer($user),
            'token' => $token
        ]);
    }

    /**
     * @throws \Exception
     */
    public function loginByGoogle(Request $request, ApiResponse $response)
    {
        $client = new \Google_Client();
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env("GOOGLE_CLIENT_SECRET"));

        $googleAccount = $client->verifyIdToken($request->input("access_token"));

        if ($googleAccount === false) {
            return $response->error("Invalid Token");
        }

        $user = $this->userService->findByLogin($googleAccount['email']);

        if (is_null($user)) {
            $newPassword = Str::random(8);

            $newUserDTO = new CreateUserDTO(
                $googleAccount['name'],
                $googleAccount['email'],
                $newPassword,
                UserType::USER
            );

            $newUser = $this->userService->create($newUserDTO);
            $newUser = $this->userService->updateAvatar($newUser, file_get_contents($googleAccount['picture']));

            $authToken = $this->userService->createToken($newUser, 'auth_token');

            return $response->success(
                new UserTransformer($newUser),
                trans('auth.success_registration'),
                [
                    "token"             => $authToken,
                    "needResetPassword" => true,
                    "tempPassword"      => $newPassword
                ],
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $response->success(
            new UserTransformer($user),
            meta: ['token' => $token]
        );
    }

    public function loginByLine(Request $request, ApiResponse $response)
    {
        $http = new Client();

        try {
            $lineResponse = $http->post('https://api.line.me/oauth2/v2.1/verify', [
                'form_params' => [
                    'id_token'  => $request->input('access_token'),
                    'client_id' => env("LINE_CLIENT_ID")
                ]
            ]);

            $responseBody = json_decode($lineResponse->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);

            if (is_null($responseBody['email'])) {
                return $response->error("Line account must have email address");
            }

            $user = $this->userService->findByLogin($responseBody['email']);

            if (isset($user)) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return $response->success(
                    new UserTransformer($user),
                    meta: ['token' => $token]
                );
            }

            $newPassword = Str::random(8);

            $newUserDTO = new CreateUserDTO(
                $responseBody['name'],
                $responseBody['email'],
                $newPassword,
                UserType::USER
            );

            $newUser = $this->userService->create($newUserDTO);
            $newUser = $this->userService->updateAvatar($newUser, file_get_contents($responseBody['picture']));

            $authToken = $this->userService->createToken($newUser, 'auth_token');

            return $response->success(
                new UserTransformer($newUser),
                trans('auth.success_registration'),
                [
                    "token"             => $authToken,
                    "needResetPassword" => true,
                    "tempPassword"      => $newPassword
                ],
            );
        } catch (\Exception) {
            return $response->error("Invalid Token");
        }
    }

    public function loginByApple(Request $request, ApiResponse $response) {
        $user = $this->userService->findByLogin($request->str('email'));

        if (isset($user)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return $response->success(
                new UserTransformer($user),
                meta: ['token' => $token]
            );
        }

        $newPassword = Str::random(8);

        $newUserDTO = new CreateUserDTO(
            $request->str('name'),
            $request->str('email'),
            $newPassword,
            UserType::USER
        );

        $newUser = $this->userService->create($newUserDTO);

        $authToken = $this->userService->createToken($newUser, 'auth_token');

        return $response->success(
            new UserTransformer($newUser),
            trans('auth.success_registration'),
            [
                "token"             => $authToken,
                "needResetPassword" => true,
                "tempPassword"      => $newPassword
            ],
        );
    }

    public function changePassword(SendOtpRequest $request, ApiResponse $response): JsonResponse
    {
        $dto = $request->getDTO();
        $user = $this->userService->findByLogin($dto->login);

        if (is_null($user)) {
            return $response->error(trans("auth.failed"));
        }

        if ($user->email === $dto->login) {
            $otpType = OtpType::EMAIL;
        } else {
            $otpType = OtpType::PHONE;
        }

        $this->otpService->create($user, $otpType);

        return $response->success([], trans('passwords.otp_sent'));
    }

    public function resetPassword(Request $request, ApiResponse $response)
    {
        $otp = $this->otpService->findByCode($request->str("otp_code"));

        if (is_null($otp)) {
            return $response->error(trans('passwords.token'));
        }

        $user = $otp->user;
        $user->password = Hash::make($request->str("password"));
        $user->save();

        $otp->is_verified = true;
        $otp->save();

        return $response->success([], trans('passwords.reset'));
    }
}
