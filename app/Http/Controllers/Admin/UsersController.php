<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enum\Finance\WalletCurrency;
use App\Enum\Users\UserType;
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
    public function downloadUsersCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        $users = User::all();

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Type', 'CP_Balance', 'Usd_Balance', 'Created By']); 

            foreach ($users as $user) {
                $creator = User::find($user->created_by);
                $creatorName = $creator ? $creator->name : 'Unknown';

                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->user_type,
                    $user->cp_token_balance,
                    $user->usd_balance,
                    $creatorName 
                ]); 
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
    public function destroy(User $user)
    {
        $this->userService->destroy($user);
        return redirect()->back()->with('success', 'User deleted successfully.');
        // return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
