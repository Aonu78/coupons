<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopContact
 *
 * @method static Builder|ShopContact newModelQuery()
 * @method static Builder|ShopContact newQuery()
 * @method static Builder|ShopContact query()
 * @property int $id
 * @property string $contact_uuid
 * @property int $shop_id
 * @property string $contact_name
 * @property string $contact_name_furigana
 * @property string|null $contact_phone_number
 * @property string|null $shop_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Shop|null $shop
 * @method static Builder|ShopContact whereContactName($value)
 * @method static Builder|ShopContact whereContactNameFurigana($value)
 * @method static Builder|ShopContact whereContactPhoneNumber($value)
 * @method static Builder|ShopContact whereContactUuid($value)
 * @method static Builder|ShopContact whereCreatedAt($value)
 * @method static Builder|ShopContact whereId($value)
 * @method static Builder|ShopContact whereShopId($value)
 * @method static Builder|ShopContact whereShopUrl($value)
 * @method static Builder|ShopContact whereUpdatedAt($value)
 * @mixin Eloquent
 */
final class ShopContact extends Model
{
    protected $guarded = [];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
