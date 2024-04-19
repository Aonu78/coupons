<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $location_uuid
 * @property string $location_postal_code
 * @property string $location_prefecture
 * @property string $location_city
 * @property string $location_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationPostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationPrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Location extends Model
{
    use HasFactory;
}
