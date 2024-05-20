<?php

namespace App\Services\Coupons;

use App\Models\User;
use App\Models\Game;
use App\Models\Coupon;
use App\ValueObject\Money;
use App\Models\UsersCoupons;
use App\Services\GameService;
use App\Constants\CouponsFiles;
use Illuminate\Support\Facades\DB;
use App\Enum\Finance\WalletCurrency;
use App\Services\Finance\TransactionService;
use Illuminate\Database\Eloquent\Collection;
use App\DataTransfer\Coupons\CreateCouponDTO;
use App\DataTransfer\Coupons\UpdateCouponDTO;
use App\Services\Filesystem\FilesystemService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Finance\Transaction\TransactionOperation;

final class CouponsService
{
    public function __construct(
        private readonly Coupon $couponModel,
        private readonly UsersCoupons $usersCouponModel,
        private readonly FilesystemService $filesystemService,
        private readonly GameService $gameService
    ) {}

    public function find(int $id): ?Coupon
    {
        $query = $this->couponModel->newQuery();

        return $query->find($id);
    }

    public function getAll(?string $name = null): LengthAwarePaginator
    {
        $query = $this->couponModel->newQuery();

        if (!empty($name)) {
            $query->whereRaw('LOWER(`name`) LIKE ?', [ '%' . strtolower($name) . '%' ] );
        }

        // $query->whereDate('coupon_usage_end_date', '>=', now());

        return $query->paginate();
    }

    public function buy(Coupon $coupon, User $buyer): Coupon
    {
        return DB::transaction(function () use ($coupon, $buyer) {
            $price = new Money($coupon->price);

//            $this->transactionService->execute(
//                $reward,
//                $buyer,
//                $cpWallet,
//                TransactionOperation::DEBIT,
//                TransactionType::GAME,
//                "Buy Coupon Reward"
//            );

            $coupon->users()->attach($buyer->id, [
                "buy_price" => $price->getAmountFloat(),
                "created_at" => now()
            ]);

            return $coupon;
        });
    }

    public function getBoughtCoupons(User $user): LengthAwarePaginator
    {
        return $user->boughtCoupons()->wherePivotNull('used_at')
            ->withPivot(['id', 'buy_price', 'created_at'])->paginate();
    }

    public function findBoughtCoupons(User $user, int $couponId): Coupon
    {
        return $user->boughtCoupons()->withPivot(['id', 'buy_price', 'created_at'])->find($couponId);
    }

    public function getFavouriteCoupons(User $user): LengthAwarePaginator
    {
        return $user->favouriteCoupons()->paginate();
    }

    public function findFavouriteCoupons(User $user, int $couponId): ?Coupon
    {
        return $user->favouriteCoupons()->find($couponId);
    }

    public function addFavouriteCoupon(User $user, int $couponId): void
    {
        $user->favouriteCoupons()->attach($couponId);
    }

    public function removeFavouriteCoupon(User $user, int $couponId): void
    {
        $user->favouriteCoupons()->detach($couponId);
    }

    public function findUserBoughtCoupon(User $user, int $boughtCouponId): ?Coupon
    {
        return $user->boughtCoupons()->wherePivot("id", $boughtCouponId)
            ->withPivot(['id', 'buy_price', "used_at" ,'created_at'])->first();
    }

    public function getUserUsedCoupons(User $user): LengthAwarePaginator
    {
        return $user->boughtCoupons()->wherePivotNotNull("used_at")
            ->withPivot(['id', 'buy_price', "used_at", 'created_at'])->paginate();
    }

    public function findBoughtCoupon(int $boughtCouponId): ?UsersCoupons
    {
        return $this->usersCouponModel->find($boughtCouponId);
    }

    public function useCoupon(UsersCoupons $coupon): UsersCoupons
    {
        $coupon->used_at = now();
        $coupon->save();

        return $coupon;
    }

    public function getShopCoupons(User $shopHolder): LengthAwarePaginator
    {
        return $shopHolder->coupons()->paginate();
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function createCoupon(User $couponHolder, CreateCouponDTO $couponDTO): Coupon
    {
        return DB::transaction(function () use ($couponHolder, $couponDTO) {
            $coupon = $this->couponModel->newInstance();

            $coupon->user_id = $couponHolder->id;
            $coupon->name = $couponDTO->name;
            $coupon->price = $couponDTO->price;
            $coupon->sale_start_date = $couponDTO->saleStartDate;
            $coupon->sale_end_date = $couponDTO->saleEndDate;
            $coupon->coupon_usage_start_date = $couponDTO->usageStartDate;
            $coupon->coupon_usage_end_date = $couponDTO->usageEndDate;
            $coupon->coupon_description = $couponDTO->description;
            $coupon->coupon_rebuyible = $couponDTO->rebuyible;
            $coupon->coupons_available = $couponDTO->couponsAvailable;

            if ($couponDTO->hasGame()) {
                $game = $this->gameService->find($couponDTO->gameId);

                if (!is_null($game)) {
                    $coupon->game()->associate($game);
                }
            }

            $coupon->save();

            $this->filesystemService->save(
                sprintf(CouponsFiles::COUPON_IMAGE, $coupon->id),
                $couponDTO->convertIconToFileContent()
            );

            return $coupon;
        });
    }

    /**
     * @throws \Exception
     */
    public function updateCoupon(Coupon $coupon, UpdateCouponDTO $couponDTO): Coupon
    {
        $coupon->name = $couponDTO->name;
        $coupon->price = $couponDTO->price;
        $coupon->sale_start_date = $couponDTO->saleStartDate;
        $coupon->sale_end_date = $couponDTO->saleEndDate;
        $coupon->coupon_usage_start_date = $couponDTO->usageStartDate;
        $coupon->coupon_usage_end_date = $couponDTO->usageEndDate;
        $coupon->coupon_description = $couponDTO->description;
        $coupon->coupon_rebuyible = $couponDTO->rebuyible;
        $coupon->coupons_available = $couponDTO->couponsAvailable;

        if ($couponDTO->hasGame()) {
            $game = $this->gameService->find($couponDTO->gameId);

            if (!is_null($game)) {
                $coupon->game()->associate($game);
            }
        }

        $coupon->save();

        if ($couponDTO->hasIcon()) {
            $this->filesystemService->save(
                sprintf(CouponsFiles::COUPON_IMAGE, $coupon->id),
                $couponDTO->convertIconToFileContent()
            );
        }

        return $coupon;
    }

    public function associateWithGame(Coupon $coupon, Game $game): Coupon
    {
        $coupon->game()->associate($game);
        $coupon->save();

        return $coupon;
    }

    public function countShopBoughtCoupons(User $user): int
    {
        $couponsIDs = $user->coupons()->pluck("id");

        $query = $this->usersCouponModel->newQuery();

        return $query->whereIn("coupon_id", $couponsIDs)->count();
    }

    public function getShopBoughtCoupons(User $user): Collection
    {
        $query = $user->coupons()->newQuery();

        return $query->whereHas("users")->withCount("users")->get();
    }

    public function getShopUsedCoupons(User $user): int
    {
        $couponsIDs = $user->coupons()->pluck("id");

        $query = $this->usersCouponModel->newQuery();

        $count = $query->whereIn("coupon_id", $couponsIDs)->whereNotNull('used_at')->count();

        return $count;
    }

    public function getShopCouponsTotalSelling(User $user): float
    {
        $couponsIDs = $user->coupons()->pluck("id");

        $query = $this->usersCouponModel->newQuery();

        $sum = $query->whereIn("coupon_id", $couponsIDs)->sum("buy_price");

        return $sum * .7;
    }
}
