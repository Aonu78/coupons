<?php

namespace App\Models;

use App\Enum\Tournaments\Players\PlayerStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TournamentPlayers
 *
 * @property int $id
 * @property string $player_uuid
 * @property int $tournament_id
 * @property int $user_id
 * @property float|null $player_score
 * @property int $is_winner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers query()
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereIsWinner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers wherePlayerScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers wherePlayerStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers wherePlayerUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereTournamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereUserId($value)
 * @property-read \App\Models\User|null $user
 * @property PlayerStatus $player_status
 * @property-read \App\Models\Tournament|null $tournament
 * @property int $is_bot
 * @method static \Illuminate\Database\Eloquent\Builder|TournamentPlayers whereIsBot($value)
 * @mixin \Eloquent
 */
class TournamentPlayers extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'player_status' => PlayerStatus::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
