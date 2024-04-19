<?php

namespace App\Http\Controllers\Api\Shop;

use App\Services\GameService;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Coupons\CouponsService;
use App\DataTransfer\Coupons\AssociateWithGameDTO;
use App\Http\Resources\Shop\Coupons\CouponTransformer;
use App\Http\Requests\Shop\Coupons\CreateCouponsRequest;
use App\Http\Requests\Shop\Coupons\UpdateCouponsRequest;
use App\Http\Resources\Shop\Coupons\BoughtCouponTransformer;
use App\Http\Requests\Shop\Coupons\AssociateWIthGameRequest;
use App\Http\Resources\Shop\Coupons\BoughtCouponsTransformer;

final class CouponsController extends Controller
{
    public function __construct(
        private readonly GameService $gameService,
        private readonly CouponsService $couponsService
    ) {}

    public function index(ApiResponse $response): JsonResponse
    {
        $user = Auth::user();

        $coupons = $this->couponsService->getShopCoupons($user);

        return $response->success(
            CouponTransformer::collection($coupons),
            meta: ApiResponse::buildPaginationMeta($coupons)
        );
    }

    public function find(int $id, ApiResponse $response): JsonResponse
    {
        $coupon = $this->couponsService->find($id);

        if (is_null($coupon)) {
            return $response->error("Coupon Not Found");
        }

        return $response->success(new CouponTransformer($coupon));
    }

    /**
     * @throws \Exception
     */
    public function create(CreateCouponsRequest $request, ApiResponse $response): JsonResponse
    {
        $user = Auth::user();

        $coupon = $this->couponsService->createCoupon($user, $request->getDTO());

        return $response->success(new CouponTransformer($coupon));
    }

    /**
     * @throws \Exception
     */
    public function update(int $id, UpdateCouponsRequest $request, ApiResponse $response): JsonResponse
    {
        $coupon = $this->couponsService->find($id);

        if (is_null($coupon)) {
            return $response->error("Coupon Not Found");
        }

        $updatedCoupon = $this->couponsService->updateCoupon($coupon, $request->getDTO());

        return $response->success(new CouponTransformer($updatedCoupon));
    }

    public function delete(int $id, ApiResponse $response): JsonResponse
    {
        $coupon = $this->couponsService->find($id);

        if (is_null($coupon)) {
            return $response->error("Coupon Not Found");
        }

        $coupon->delete();

        return $response->success(null);
    }

    public function associateWithGame(int $id, AssociateWIthGameRequest $request, ApiResponse $response)
    {
        $coupon = $this->couponsService->find($id);

        if (is_null($coupon)) {
            return $response->error("Coupon Not Found.");
        }

        $game = $this->gameService->find($request->getDTO()->gameId);

        if (is_null($game)) {
            return $response->error("Game Not Found.");
        }

        $updatedCoupon = $this->couponsService->associateWithGame($coupon, $game);

        return $response->success(new CouponTransformer($updatedCoupon));
    }

    public function findBoughtCoupon(int $id, ApiResponse $response)
    {
        $userCoupon = $this->couponsService->findBoughtCoupon($id);

        if (is_null($userCoupon)) {
            return $response->error("Coupon Not Found.");
        }

        return $response->success(new BoughtCouponTransformer($userCoupon));
    }

    public function useBoughtCoupon(int $id, ApiResponse $response)
    {
        $userCoupon = $this->couponsService->findBoughtCoupon($id);

        if (is_null($userCoupon)) {
            return $response->error("Coupon Not Found.");
        }

        if (isset($userCoupon->used_at)) {
            return $response->error("Coupon has been used before!");
        }

        $this->couponsService->useCoupon($userCoupon);

        return $response->success(null);
    }

    public function getStats(ApiResponse $response): JsonResponse
    {
        $user = Auth::user();

        $countBoughtCoupons = $this->couponsService->countShopBoughtCoupons($user);
        $boughtCoupons = $this->couponsService->getShopBoughtCoupons($user);
        $totalSelling = $this->couponsService->getShopCouponsTotalSelling($user);
        $usedCoupons = $this->couponsService->getShopUsedCoupons($user);

        return $response->success([
            "total_bought"   => $countBoughtCoupons,
            "total_selling"  => $totalSelling,
            "used_coupons"   => $usedCoupons,
            "bought_coupons" => BoughtCouponsTransformer::collection($boughtCoupons),
        ]);
    }
}
