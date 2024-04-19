<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UsersCoupons
 *
 * @property int $id
 * @property int $user_id
 * @property int $coupon_id
 * @property float $buy_price
 * @property string|null $used_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UsersCoupons newModelQuery()
 * @method static Builder|UsersCoupons newQuery()
 * @method static Builder|UsersCoupons query()
 * @method static Builder|UsersCoupons whereBuyPrice($value)
 * @method static Builder|UsersCoupons whereCouponId($value)
 * @method static Builder|UsersCoupons whereCreatedAt($value)
 * @method static Builder|UsersCoupons whereId($value)
 * @method static Builder|UsersCoupons whereUpdatedAt($value)
 * @method static Builder|UsersCoupons whereUsedAt($value)
 * @method static Builder|UsersCoupons whereUserId($value)
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \App\Models\User|null $user
 * @mixin Eloquent
 */
final class UsersCoupons extends Pivot
{
    protected $table = "users_coupons";

    public $incrementing = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
