<?php

namespace App\Http\Controllers\Api\Coupons;

use App\Models\User;
use App\ValueObject\Money;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use App\Support\Http\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enum\Finance\WalletCurrency;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use App\Http\Resources\UserTransformer;
use App\Services\Coupons\CouponsService;
use Endroid\QrCode\ErrorCorrectionLevel;
use App\Http\Resources\Coupons\CouponsTransformer;
use App\Http\Requests\Api\Coupons\BuyCouponRequest;
use App\Http\Resources\Coupons\MyCouponsTransformer;
use App\Http\Resources\Shop\Coupons\BoughtCouponsTransformer;
use App\Http\Requests\Api\Coupons\TriggerFavouriteCouponRequest;

final class CouponsController extends Controller
{
    public function __construct(
        private readonly CouponsService $couponsService
    ) {}

    public function index(Request $request, ApiResponse $response): JsonResponse
    {
        $coupons = $this->couponsService->getAll($request->str("name"));

        return $response->success(
            CouponsTransformer::collection($coupons),
            meta: ApiResponse::buildPaginationMeta($coupons)
        );
    }

    /**
     * @throws \Exception
     */
    public function buyCoupon(BuyCouponRequest $request, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->createOrGetStripeCustomer();
        $dto = $request->getDTO();

        $coupon = $this->couponsService->find($dto->couponId);

        if (is_null($coupon)) {
            return $response->error(trans("coupons.not_found"));
        }

        $price = new Money($coupon->price);

        if ($user->findPaymentMethod($dto->paymentMethod) === null) {
            return $response->error(trans("billing.invalid_card"));
        }


        try {
            $objCharge = $user->charge(
                $price->getAmountFloat() * 100,
                $dto->paymentMethod
            );
        } catch (\Exception $exception) {
            return $response->error($exception->getMessage());
        }

        if ($objCharge->isSucceeded() === false) {
            return $response->error(trans('messages.default_error'));
        }

        $coupon = $this->couponsService->buy($coupon, $user);
        $boughtCoupon = $this->couponsService->findBoughtCoupons($user, $coupon->id);

        return $response->success([
            "coupon" => new MyCouponsTransformer($boughtCoupon),
            "user" => new UserTransformer($user)
        ], trans('coupons.success_bought'));
    }

    public function myCoupons(ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $myCoupons = $this->couponsService->getBoughtCoupons($user);

        return $response->success(
            MyCouponsTransformer::collection($myCoupons),
            meta: ApiResponse::buildPaginationMeta($myCoupons)
        );
    }

    public function myFavouriteCoupons(ApiResponse $response): JsonResponse
    {
        $user = Auth::user();

        $favouriteCoupons = $this->couponsService->getFavouriteCoupons($user);

        return $response->success(
            CouponsTransformer::collection($favouriteCoupons)
        );
    }

    public function triggerFavouriteCoupon(TriggerFavouriteCouponRequest $request, ApiResponse $response): JsonResponse
    {
        $user = Auth::user();

        $coupon = $this->couponsService->findFavouriteCoupons($user, $request->integer("coupon_id"));

        if (is_null($coupon)) {
            $this->couponsService->addFavouriteCoupon($user, $request->integer("coupon_id"));
        } else {
            $this->couponsService->addFavouriteCoupon($user, $request->integer("coupon_id"));
        }

        return $response->success(null);
    }

    public function getBoughtCouponCode(int $id, ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $myCoupon = $this->couponsService->findUserBoughtCoupon($user, $id);

        if (is_null($myCoupon)) {
            return $response->error(trans('coupons.not_found'));
        }

        $couponUsagePage = route('coupons.use', $id);

        $writer = new PngWriter();

        $qrCode = QrCode::create($id)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));


        $result = $writer->write($qrCode);

        return $response->success([
            "coupon_qr_code"    => $result->getDataUri(),
            "coupon_usage_link" => $couponUsagePage
        ]);
    }

    public function getUsedCoupons(ApiResponse $response): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $myCoupons = $this->couponsService->getUserUsedCoupons($user);

        return $response->success(
            MyCouponsTransformer::collection($myCoupons),
            meta: ApiResponse::buildPaginationMeta($myCoupons)
        );
    }
}
