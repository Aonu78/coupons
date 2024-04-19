<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Services\TournamentService;
use Illuminate\Support\Facades\Auth;
use App\Enum\Tournaments\TournamentType;
use Illuminate\Database\Eloquent\Builder;
use App\Enum\Tournaments\TournamentStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enum\Tournaments\TournamentFinishingTrigger;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tournament
 *
 * @property int $id
 * @property int $game_id
 * @property string $tournament_uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Tournament newModelQuery()
 * @method static Builder|Tournament newQuery()
 * @method static Builder|Tournament query()
 * @method static Builder|Tournament whereCreatedAt($value)
 * @method static Builder|Tournament whereGameId($value)
 * @method static Builder|Tournament whereId($value)
 * @method static Builder|Tournament whereTournamentStatus($value)
 * @method static Builder|Tournament whereTournamentType($value)
 * @method static Builder|Tournament whereTournamentUuid($value)
 * @method static Builder|Tournament whereUpdatedAt($value)
 * @property-read \App\Models\Game|null $game
 * @property TournamentType $tournament_type
 * @property TournamentStatus $tournament_status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TournamentPlayers> $players
 * @property-read int|null $players_count
 * @property int $has_bot
 * @property float $tournament_bet
 * @method static Builder|Tournament whereHasBot($value)
 * @method static Builder|Tournament whereTournamentBet($value)
 * @property TournamentFinishingTrigger $tournament_finishing_trigger
 * @property string|null $tournament_starts_at
 * @property string|null $tournament_ends_at
 * @method static Builder|Tournament whereTournamentEndsAt($value)
 * @method static Builder|Tournament whereTournamentFinishingTrigger($value)
 * @method static Builder|Tournament whereTournamentStartsAt($value)
 * @mixin \Eloquent
 */
final class Tournament extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "tournament_type"              => TournamentType::class,
        "tournament_status"            => TournamentStatus::class,
        "tournament_finishing_trigger" => TournamentFinishingTrigger::class
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(TournamentPlayers::class);
    }

    public function isFull(): bool
    {
        return $this->players->count() >= 5;
    }

    public function getAuthPlayer()
    {
        /** @var User $objUser */
        $objUser = Auth::guard("sanctum")->user();

        if (is_null($objUser)) {
            return null;
        }

        /** @var TournamentService $tournamentService */
        $tournamentService = app(TournamentService::class);

        return $tournamentService->getTournamentPlayer($this, $objUser);
    }

    public function getWinner(): ?TournamentPlayers
    {
        if ($this->tournament_status !== TournamentStatus::FINISHED) {
            return null;
        }

        /** @var TournamentService $tournamentService */
        $tournamentService = app(TournamentService::class);

        return $tournamentService->getWinner($this);
    }
}
