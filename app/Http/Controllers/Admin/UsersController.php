<?php

namespace App\Http\Controllers\Admin;

use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enum\Finance\WalletCurrency;

final class UsersController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index()
    {
        $users = $this->userService->getUsersWithoutBots();

        return view('admin.users.index', compact('users'));
    }

    public function edit(int $id)
    {
        $user = $this->userService->findById($id);

        if (is_null($user)) {
            return redirect()->route('admin.users.index');
        }

        $cpTokenWallet = $user->getWallet(WalletCurrency::CP_TOKEN);
        $usdWallet = $user->getWallet(WalletCurrency::USD);

        return view('admin.users.edit', compact('user', 'cpTokenWallet', 'usdWallet'));
    }
}
