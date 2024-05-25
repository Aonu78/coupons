<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use App\Constants\CouponsFiles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Filesystem\FilesystemService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $game_id
 * @property string $name
 * @property string|null $coupon_description
 * @property float $price
 * @property int|null $coupons_available
 * @property int $coupon_rebuyible
 * @property string $sale_start_date
 * @property string $sale_end_date
 * @property string|null $coupon_usage_start_date
 * @property string|null $coupon_usage_end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, User> $favouriteUsers
 * @property-read int|null $favourite_users_count
 * @property-read Game|null $game
 * @property-read string $background
 * @property-read string $image
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static Builder|Coupon newModelQuery()
 * @method static Builder|Coupon newQuery()
 * @method static Builder|Coupon query()
 * @method static Builder|Coupon whereCouponDescription($value)
 * @method static Builder|Coupon whereCouponRebuyible($value)
 * @method static Builder|Coupon whereCouponUsageEndDate($value)
 * @method static Builder|Coupon whereCouponUsageStartDate($value)
 * @method static Builder|Coupon whereCouponsAvailable($value)
 * @method static Builder|Coupon whereCreatedAt($value)
 * @method static Builder|Coupon whereGameId($value)
 * @method static Builder|Coupon whereId($value)
 * @method static Builder|Coupon whereName($value)
 * @method static Builder|Coupon wherePrice($value)
 * @method static Builder|Coupon whereSaleEndDate($value)
 * @method static Builder|Coupon whereSaleStartDate($value)
 * @method static Builder|Coupon whereUpdatedAt($value)
 * @method static Builder|Coupon whereUserId($value)
 * @property-read \App\Models\User|null $couponCreator
 * @property string|null $deleted_at
 * @method static Builder|Coupon whereDeletedAt($value)
 * @mixin Eloquent
 */
final class Coupon extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'name',
        'price',
        'sale_start_date',
        'sale_end_date',
        'coupon_usage_start_date',
        'coupon_usage_end_date',
        'coupon_description',
        'coupon_rebuyible',
        'coupons_available',
        'coupon_image', // Add this line
    ];
    protected $guarded = [];

    // public function getImageAttribute(): string
    // {
    //     $objFilesystem = FilesystemService::factory();

    //     $imagePath = sprintf(
    //         CouponsFiles::COUPON_IMAGE,
    //         $this->id
    //     );

    //     return $objFilesystem->url($imagePath) . "?nocache=" . time();
    // }

    public function getBackgroundAttribute(): string
    {
        $objFilesystem = FilesystemService::factory();

        $imagePath = sprintf(
            CouponsFiles::COUPON_BG_IMAGE,
            $this->id
        );

        return $objFilesystem->url($imagePath) . "?nocache=" . time();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_coupons')->using(UsersCoupons::class);
    }

    public function couponCreator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function favouriteUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "users_favourite_coupons");
    }

    public function isInUserFavourite(User $user): bool
    {
        $favUser = $this->favouriteUsers()->find($user->id);

        return !is_null($favUser);
    }
}
