<?php

namespace App\Http\Controllers\Auth;

use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class InviteController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function show(string $code)
    {
        $user = $this->userService->findByInviteCode($code);

        if (is_null($user)) {
            return redirect()->to('/');
        }

        return view('auth.invite', compact('user'));
    }
}
