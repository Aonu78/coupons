<?php

namespace App\Models\Finance;


use App\Casts\MoneyCast;
use App\Traits\HasWallet;
use App\Traits\HasTransactions;
use App\Enum\Finance\WithdrawStatus;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\WalletHolderContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Finance\Withdraw
 *
 * @property int $id
 * @property string $withdraw_uuid
 * @property string $entity_type
 * @property int $entity_id
 * @property WithdrawStatus $withdraw_status
 * @property string|null $withdraw_reject_reason
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\ValueObject\Money $withdraw_history_amount
 * @property-read Model|\Eloquent $entity
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\Wallet> $wallets
 * @property-read int|null $wallets_count
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw query()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereWithdrawRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereWithdrawStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereWithdrawUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw withoutTrashed()
 * @property string|null $withdraw_target Stripe Payment Method ID
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereWithdrawTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereWithdrawHistoryAmount($value)
 * @mixin \Eloquent
 */
final class Withdraw extends Model implements WalletHolderContract
{
    use SoftDeletes, HasTransactions, HasWallet;

    protected $guarded = [];

    protected $casts = [
        "withdraw_status"         => WithdrawStatus::class,
        "withdraw_history_amount" => MoneyCast::class
    ];

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }
}
