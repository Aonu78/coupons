<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enum\Users\UserType;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

final class AuthenticationController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $user = $this->userService->findByLogin($request->str("email"));

        if (is_null($user) || $user->user_type !== UserType::ADMIN->value) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
