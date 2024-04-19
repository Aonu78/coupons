<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FakeCards
 *
 * @property int $id
 * @property int $user_id
 * @property string $card_number
 * @property string $card_cvc
 * @property int $card_exp_month
 * @property string $card_exp_year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards query()
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereCardCvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereCardExpMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereCardExpYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FakeCards whereUserId($value)
 * @mixin \Eloquent
 */
class FakeCards extends Model
{
    use HasFactory;

    protected $guarded = [];
}
