<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enum\Finance\WalletCurrency;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Finance\Transaction\TransactionStatus;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Enum\Finance\Transaction\TransactionProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\Finance\Transaction\TransactionOperation;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $transaction_uuid
 * @property string $entity_type
 * @property int $entity_id
 * @property \App\ValueObject\Money $transaction_amount
 * @property string $transaction_description
 * @property TransactionOperation $transaction_operation
 * @property TransactionType $transaction_type
 * @property TransactionProvider $transaction_provider
 * @property TransactionStatus $transaction_status
 * @property WalletCurrency $transaction_currency
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $entity
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withoutTrashed()
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        "transaction_amount"    => MoneyCast::class,
        "transaction_operation" => TransactionOperation::class,
        "transaction_type"      => TransactionType::class,
        "transaction_provider"  => TransactionProvider::class,
        "transaction_status"    => TransactionStatus::class,
        "transaction_currency"  => WalletCurrency::class
    ];

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }
}
