<?php

namespace App\Http\Controllers\Api\Shop;

use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\User\CompanyService;
use App\Http\Resources\User\CompanyTransformer;
use App\Http\Requests\Shop\Company\SaveCompanyRequest;

final class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $companyService) {}

    public function getUserCompany(ApiResponse $response): JsonResponse
    {
        $user = Auth::user();
        $company = $this->companyService->getUserCompany($user);

        if (is_null($company)) {
            return $response->success(null);
        }

        return $response->success(new CompanyTransformer($company));
    }

    public function saveCompany(SaveCompanyRequest $request, ApiResponse $response): JsonResponse
    {
        $user = Auth::user();

        $company = $this->companyService->save($user, $request->getDTO());

        return $response->success(new CompanyTransformer($company));
    }
}
