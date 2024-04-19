<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use App\Models\Games\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property string $game_uuid
 * @property string $game_name
 * @property int $game_active
 * @property int $game_visible
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Game newModelQuery()
 * @method static Builder|Game newQuery()
 * @method static Builder|Game query()
 * @method static Builder|Game whereCreatedAt($value)
 * @method static Builder|Game whereDeletedAt($value)
 * @method static Builder|Game whereGameActive($value)
 * @method static Builder|Game whereGameName($value)
 * @method static Builder|Game whereGameUuid($value)
 * @method static Builder|Game whereGameVisible($value)
 * @method static Builder|Game whereId($value)
 * @method static Builder|Game whereUpdatedAt($value)
 * @property-read Collection<int, Tournament> $tournaments
 * @property-read int|null $tournaments_count
 * @property string $game_description
 * @property string|null $game_image
 * @property-read string $image
 * @method static Builder|Game whereGameDescription($value)
 * @method static Builder|Game whereGameImage($value)
 * @property-read Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property float $game_rating
 * @method static Builder|Game whereGameRating($value)
 * @property int $is_free
 * @method static Builder|Game whereIsFree($value)
 * @mixin Eloquent
 */
class Game extends Model
{
    protected $guarded = [];

    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "categories_games");
    }

    public function getImageAttribute(): string
    {
        if (is_null($this->game_image)) {
            return "";
        }

        return Storage::disk("s3")->url($this->game_image);
    }
}
