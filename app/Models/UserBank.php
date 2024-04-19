<?php

namespace App\Models;

use App\Enum\Finance\Bank\DepositType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserBank
 *
 * @property int $id
 * @property string $bank_uuid
 * @property int $user_id
 * @property string $account_name
 * @property string $account_number
 * @property string $bank_name
 * @property int $branch_number
 * @property DepositType $deposit_type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereBankUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereBranchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereDepositType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank withoutTrashed()
 * @property string $account_name_furigana
 * @method static \Illuminate\Database\Eloquent\Builder|UserBank whereAccountNameFurigana($value)
 * @mixin \Eloquent
 */
final class UserBank extends Model
{
    use SoftDeletes;

    protected $casts = [
        "deposit_type"  => DepositType::class
    ];
}
