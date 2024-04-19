<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class CompanyController extends Controller
{
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
}
