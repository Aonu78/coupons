<?php

namespace App\Models\Games;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Games\Category
 *
 * @property int $id
 * @property string $category_uuid
 * @property array $category_name
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @property-read mixed $name
 * @mixin \Eloquent
 */
final class Category extends Model
{
    protected $guarded = [];

    protected $casts = [
        'category_name' => 'json'
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, "categories_games");
    }

    public function getTopCategoryGames(): Collection
    {
        return $this->games()->where("game_visible", true)->take(10)->get();
    }

    public function getNameAttribute()
    {
        $locale = App::getLocale();

        if (array_key_exists($locale, $this->category_name)) {
            return $this->category_name[$locale];
        }

        return $this->category_name['en'];
    }
}
