<?php

namespace App\Models;

use Eloquent;
use App\Constants\ShopFiles;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Filesystem\FilesystemService;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shop
 *
 * @property int $id
 * @property string $shop_uuid
 * @property int $user_id
 * @property string $shop_name
 * @property string $shop_name_furigana
 * @property string|null $shop_pr
 * @property string|null $shop_logo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Shop newModelQuery()
 * @method static Builder|Shop newQuery()
 * @method static Builder|Shop query()
 * @method static Builder|Shop whereCreatedAt($value)
 * @method static Builder|Shop whereId($value)
 * @method static Builder|Shop whereShopLogo($value)
 * @method static Builder|Shop whereShopName($value)
 * @method static Builder|Shop whereShopNameFurigana($value)
 * @method static Builder|Shop whereShopPr($value)
 * @method static Builder|Shop whereShopUuid($value)
 * @method static Builder|Shop whereUpdatedAt($value)
 * @method static Builder|Shop whereUserId($value)
 * @property-read ShopContact|null $contact
 * @property-read ShopLocation|null $location
 * @property-read User|null $user
 * @property-read string|null $logo
 * @property Carbon|null $deleted_at
 * @method static Builder|Shop onlyTrashed()
 * @method static Builder|Shop whereDeletedAt($value)
 * @method static Builder|Shop withTrashed()
 * @method static Builder|Shop withoutTrashed()
 * @mixin Eloquent
 */
final class Shop extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): HasOne
    {
        return $this->hasOne(ShopLocation::class);
    }

    public function contact(): HasOne
    {
        return $this->hasOne(ShopContact::class);
    }

    public function getLogoAttribute(): ?string
    {
        if (is_null($this->shop_logo)) {
            return null;
        }

        $objFilesystem = FilesystemService::factory();

        $imagePath = sprintf(
            ShopFiles::SHOP_LOGO_PATH,
            $this->shop_uuid
        );

        return $objFilesystem->url($imagePath . DIRECTORY_SEPARATOR . $this->shop_logo);
    }
}
