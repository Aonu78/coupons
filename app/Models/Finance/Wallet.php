<?php

namespace App\Models\Finance;

use Eloquent;
use App\Casts\MoneyCast;
use App\ValueObject\Money;
use Illuminate\Support\Carbon;
use App\Enum\Finance\WalletCurrency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Finance\Wallet
 *
 * @property int $id
 * @property string $wallet_uuid
 * @property string $holder_type
 * @property int $holder_id
 * @property WalletCurrency $wallet_currency
 * @property Money $wallet_balance
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model $holder
 * @method static Builder|Wallet newModelQuery()
 * @method static Builder|Wallet newQuery()
 * @method static Builder|Wallet onlyTrashed()
 * @method static Builder|Wallet query()
 * @method static Builder|Wallet whereCreatedAt($value)
 * @method static Builder|Wallet whereDeletedAt($value)
 * @method static Builder|Wallet whereHolderId($value)
 * @method static Builder|Wallet whereHolderType($value)
 * @method static Builder|Wallet whereId($value)
 * @method static Builder|Wallet whereUpdatedAt($value)
 * @method static Builder|Wallet whereWalletBalance($value)
 * @method static Builder|Wallet whereWalletCurrency($value)
 * @method static Builder|Wallet whereWalletUuid($value)
 * @method static Builder|Wallet withTrashed()
 * @method static Builder|Wallet withoutTrashed()
 * @mixin Eloquent
 */
final class Wallet extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        "wallet_currency" => WalletCurrency::class,
        "wallet_balance"  => MoneyCast::class
    ];

    public function holder(): MorphTo
    {
        return $this->morphTo();
    }
}
