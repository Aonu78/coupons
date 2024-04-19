<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCompany
 *
 * @property int $id
 * @property int $user_id
 * @property string $company_name
 * @property string $address
 * @property string $telephone_number
 * @property string $email_address
 * @property string $sns_account
 * @property string|null $bank_account_information
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereBankAccountInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereSnsAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereTelephoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereUserId($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompany withoutTrashed()
 * @mixin \Eloquent
 */
class UserCompany extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'telephone_number',
        'email_address',
        'sns_account',
        'bank_account_information'
    ];
}
