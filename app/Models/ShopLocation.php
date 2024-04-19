<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopLocation
 *
 * @property int $id
 * @property string $location_uuid
 * @property int $shop_id
 * @property string $shop_postal_code
 * @property string $shop_prefecture
 * @property string $shop_address
 * @property string|null $shop_building_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ShopLocation newModelQuery()
 * @method static Builder|ShopLocation newQuery()
 * @method static Builder|ShopLocation query()
 * @method static Builder|ShopLocation whereCreatedAt($value)
 * @method static Builder|ShopLocation whereId($value)
 * @method static Builder|ShopLocation whereLocationUuid($value)
 * @method static Builder|ShopLocation whereShopAddress($value)
 * @method static Builder|ShopLocation whereShopBuildingNumber($value)
 * @method static Builder|ShopLocation whereShopId($value)
 * @method static Builder|ShopLocation whereShopPostalCode($value)
 * @method static Builder|ShopLocation whereShopPrefecture($value)
 * @method static Builder|ShopLocation whereUpdatedAt($value)
 * @property-read Shop|null $shop
 * @mixin Eloquent
 */
final class ShopLocation extends Model
{
    protected $guarded = [];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
