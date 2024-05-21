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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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

        if (is_null($user) || $user->user_type !== UserType::AGENT->value) {
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
            $user,
            meta: ["token" => $token]
        );
    }

    /**
     * @throws \Exception
     */

    private function generateUniqueReferralCode() {
        do {
            // Generate a random 8-character alphanumeric string
            $referralCode = Str::random(8);
        } while (User::where('referral_code', $referralCode)->exists());
    
        return $referralCode;
    }  
     public function register(Request $request, ApiResponse $response): \Illuminate\Http\JsonResponse
     {   
         // Validate the incoming request data
         $validator = Validator::make($request->all(), [
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'referral_code' => 'nullable|string|max:255',
             'password' => 'required|string|min:8', // Ensure password confirmation is provided
         ]);
         
         if ($validator->fails()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Validation errors',
                 'errors' => $validator->errors(),
             ], 422);
         }
         $referralCode = $this->generateUniqueReferralCode();
         $user = new User();
         $user->name = $request->name;
         $user->email = $request->email;
         $user->referral_code = $referralCode;

         if ($request->referral_code) {
             $referringUser = User::where('referral_code', $request->referral_code)->first();
             if ($referringUser) {
                 $user->created_by = $referringUser->id;
             } else {
                 return response()->json([
                     'success' => false,
                     'message' => 'Invalid referral code',
                 ], 400);
             }
         }
     
         $user->password = Hash::make($request->password); // Hash the password
         $user->save();
        //  $user = Auth::user();
         $authToken = $user->createToken('auth_token')->plainTextToken;

         return $response->success(
            //  new UserTransformer($user),
             $user,
             trans('auth.success_registration'),
             ["token" => $authToken]
         );
     }
     
    // public function register(RegisterRequest $request, ApiResponse $response): \Illuminate\Http\JsonResponse
    // {   return $response->success("data reachecd");
    //     $user = $this->userService->create($request->getDTO());
    //     $authToken = $this->userService->createToken($user, 'auth_token');

    //     return $response->success(
    //         new UserTransformer($user),
    //         trans('auth.success_registration'),
    //         ["token" => $authToken]
    //     );
    // }
}
