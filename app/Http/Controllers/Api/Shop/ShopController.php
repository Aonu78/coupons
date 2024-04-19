<?php

namespace App\Http\Controllers\Api\Shop;

use App\Support\Http\ApiResponse;
use App\Services\Shop\ShopService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Shop\SaveUserShopRequest;
use App\Http\Resources\Shop\UserShopTransformer;

final class ShopController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService
    ) {}

    public function getMyShop(ApiResponse $response): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $userShop = $this->shopService->getUserShop($user);

        if (is_null($userShop)) {
            return $response->success(null);
        }

        return $response->success(new UserShopTransformer($userShop));
    }

    /**
     * @throws \Throwable
     */
    public function saveShop(SaveUserShopRequest $request, ApiResponse $response): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $userShop = $this->shopService->getUserShop($user);

        if (is_null($userShop)) {
            $shop = $this->shopService->create($user, $request->getDTO());
        } else {
            $shop = $this->shopService->update($userShop, $request->getDTO());
        }

        return $response->success(new UserShopTransformer($shop));
    }
}
