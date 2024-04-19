<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OtpVerifications
 *
 * @property int $id
 * @property string $otp_uuid
 * @property int $user_id
 * @property string $otp_code
 * @property int $is_verified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications query()
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereOtpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereOtpUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtpVerifications whereUserId($value)
 * @property-read \App\Models\User|null $user
 * @mixin \Eloquent
 */
final class OtpVerifications extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
