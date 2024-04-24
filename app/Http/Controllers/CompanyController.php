<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\User\UserService;
final class CompanyController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $company = $user->company;

        return view('companies.settings', compact('company'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        UserCompany::updateOrCreate(['user_id' => $user->id],
            $request->only([
                'company_name',
                'address',
                'telephone_number',
                'email_address',
                'sns_account',
                'bank_account_information'
            ])
        );

        return back();
    }
    public function main()
    {
        $users = $this->userService->getAllUsersCreatedByLoggedInUser();
        return view('companies.main', compact('users'));
    }
    public function login()
    {
        return view('companies.login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->user_type == 'company') {
                return redirect()->intended('/company');
            } else {
                Auth::logout();
                return redirect()->route('companies.login')->withErrors([
                    'email' => 'You are not authorized to access this area.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('company.login');
    }
}
