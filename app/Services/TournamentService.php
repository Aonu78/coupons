<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User;
use App\Models\Tournament;
use App\ValueObject\Money;
use Illuminate\Support\Str;
use App\Enum\Users\UserType;
use App\Models\TournamentPlayers;
use Illuminate\Support\Facades\DB;
use App\Enum\Finance\WalletCurrency;
use App\Enum\Tournaments\TournamentType;
use Illuminate\Database\Eloquent\Builder;
use App\Enum\Tournaments\TournamentStatus;
use App\Constants\TransactionDescriptions;
use App\Services\Finance\TransactionService;
use App\Enum\Tournaments\Players\PlayerStatus;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Tournaments\TournamentFinishingTrigger;
use App\Enum\Finance\Transaction\TransactionOperation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TournamentService
{
    public function __construct(
        private readonly Tournament $tournamentModel,
        private readonly TransactionService $transactionService
    ) {}

    public function all(): LengthAwarePaginator
    {
        $query = $this->tournamentModel->newQuery();

        return $query->paginate();
    }

    public function find(string $id): ?Tournament
    {
        $query = $this->tournamentModel->newQuery();

        /** @var Tournament $tournament */
        $tournament = $query->where("tournament_uuid", $id)->first();

        return $tournament;
    }

    public function create(
        Game $game,
        TournamentFinishingTrigger $finishingTrigger = TournamentFinishingTrigger::PLAYERS_COUNT
    ): Tournament {
        $tournament = $this->tournamentModel->newInstance();

        $tournament->tournament_uuid = Str::uuid();
        $tournament->game()->associate($game);
        $tournament->tournament_type = TournamentType::MULTIPLAYER;
        $tournament->tournament_status = TournamentStatus::MATCHMAKING;
        $tournament->tournament_bet = 10;
        $tournament->tournament_finishing_trigger = $finishingTrigger;
        $tournament->has_bot = true;

        if ($finishingTrigger === TournamentFinishingTrigger::TIME) {
            $tournament->tournament_starts_at = now();
            $tournament->tournament_ends_at = now()->addDays(7);
        }

        $tournament->save();

        return $tournament;
    }

    /**
     * @throws \Exception
     */
    public function join(Tournament $tournament, User $player): Tournament
    {
        if ($tournament->tournament_type !== TournamentType::MULTIPLAYER) {
            throw new \Exception("Not Supported");
        }

        if ($tournament->isFull() && $tournament->tournament_finishing_trigger !== TournamentFinishingTrigger::TIME) {
            throw new \Exception("Tournament Is Full");
        }

        /** @var TournamentPlayers $newPlayer*/
        $newPlayer = $tournament->players()->newModelInstance();

        $newPlayer->tournament()->associate($tournament);
        $newPlayer->user()->associate($player);
        $newPlayer->player_uuid = Str::uuid();
        $newPlayer->player_status = PlayerStatus::IN_GAME;
        $newPlayer->save();

        if ($player->user_type != UserType::BOT->value) {
            $game = $tournament->game;

            if ($game->is_free === false) {
                $cpWallet = $player->getWallet(WalletCurrency::CP_TOKEN);

                $this->transactionService->execute(
                    new Money(3),
                    $player,
                    $cpWallet,
                    TransactionOperation::CREDIT,
                    TransactionType::GAME,
                    sprintf(TransactionDescriptions::GAME_DEBIT, $game->game_name)
                );
            }
        }

        $tournament = $tournament->refresh();

        if ($tournament->isFull() && $tournament->tournament_finishing_trigger !== TournamentFinishingTrigger::TIME) {
            $tournament->tournament_status = TournamentStatus::IN_PROGRESS->value;
            $tournament->save();
        }

        return $tournament;
    }

    public function getTournamentPlayer(
        Tournament $tournament,
        User $user
    ): ?TournamentPlayers {
        $query = $tournament->players()->newQuery();

        /** @var ?TournamentPlayers $player */
        $player = $query->where("user_id", $user->id)->first();

        return $player;
    }

    public function startMatch(Tournament $tournament): Tournament
    {
        $tournament->players()->update([
           'player_status' => PlayerStatus::IN_GAME->value
        ]);

        return $tournament;
    }

    public function finishMatch(TournamentPlayers $player, float $score): TournamentPlayers
    {
        if ($player->player_status !== PlayerStatus::IN_GAME) {
            throw new \Exception("You cannot finish the match", 400);
        }

        $tournament = $player->tournament;

        $player->player_status = PlayerStatus::GAME_FINISHED;
        $player->player_score = $score;
        $player->save();

        if ($tournament->has_bot) {
            /** @var TournamentPlayers $bot */
            $bots = $tournament->players()->whereNot('id', $player->id)->get();

            foreach ($bots as $bot) {
                $bot->player_status = PlayerStatus::GAME_FINISHED;
                $bot->player_score = rand(1, intval($score - 1));
                $bot->save();
            }
        }

        $finishedPlayers = $this->getTournamentPlayersCount(
            $tournament,
            PlayerStatus::GAME_FINISHED
        );

        if ($finishedPlayers === 5 && $tournament->tournament_finishing_trigger !== TournamentFinishingTrigger::TIME) {
            $this->selectWinner($tournament);
        }

        return $player;
    }

    public function getWinner(Tournament $tournament): ?TournamentPlayers
    {
        $query = $tournament->players()->newQuery();

        /** @var ?TournamentPlayers $winner */
        $winner = $query->where("is_winner", true)->first();

        return $winner;
    }

    public function getTournamentPlayersCount(Tournament $tournament, ?PlayerStatus $playerStatus = null): int
    {
        $query = $tournament->players()->newQuery();

        if (!is_null($playerStatus)) {
            $query = $query->where("player_status", $playerStatus->value);
        }

        return $query->count();
    }

    public function selectWinner(Tournament $tournament): TournamentPlayers
    {
        return DB::transaction(function () use ($tournament) {
            $query = $tournament->players()->newQuery();

            /** @var TournamentPlayers $winner */
            $winner = $query->orderBy('player_score', 'desc')->where('is_bot', false)->first();
            $winner->is_winner = true;
            $winner->save();

            $tournament->tournament_status = TournamentStatus::FINISHED;
            $tournament->save();

            $tournament->players()->update([
                "player_status" => PlayerStatus::TOURNAMENT_FINISHED
            ]);

            $user = $winner->user;

            $user->save();

            $game = $tournament->game;

            if ($game->is_free) {
                return $winner;
            }

            $winningCP = new Money((10 * $tournament->players()->count()) * 0.05);


            $this->transactionService->execute(
                $winningCP,
                $user,
                $user->getWallet(WalletCurrency::USD),
                TransactionOperation::DEBIT,
                TransactionType::GAME,
                sprintf(TransactionDescriptions::GAME_WIN, $game->game_name)
            );

//            $game = $tournament->game;

//            if ($tournament->tournament_bet_type === TournamentBetType::USD) {

//            }
//
//            if ($tournament->tournament_bet_type === TournamentBetType::BITCOIN) {
//                $this->zebedeeService->payToUser($winner->user, $tournament, "Tournament Winner Prize");
//            }
//
//            event(new UpdateGameTournaments($game));

            return $winner;
        });
    }

    public function getUserHistoryByGame(Game $game, User $user)
    {
        $query = $game->tournaments()->newQuery();

        return $query->where("tournament_status", TournamentStatus::FINISHED->value)->whereHas("players", function (Builder $builder) use ($user) {
            $builder->where("user_id", $user->id);
        })->get();
    }

    public function getUserHistory(User $user): LengthAwarePaginator
    {
        $query = $this->tournamentModel->newQuery();

        return $query->where("tournament_status", TournamentStatus::FINISHED->value)->whereHas("players", function (Builder $builder) use ($user) {
            $builder->where("user_id", $user->id);
        })->orderByDesc('updated_at')->paginate();
    }

    public function calculateUserWinning(User $user): float
    {
        $query = $this->tournamentModel->newQuery();

        $winningSum = 0;

        $sumTournamentsBets = $query->where("tournament_status", TournamentStatus::FINISHED->value)->whereHas("players", function (Builder $builder) use ($user) {
            $builder->where("user_id", $user->id)->where('is_winner', true);
        })->withCount('players')->get();

        foreach ($sumTournamentsBets as $tournament) {
            $winningSum += $tournament->players_count * $tournament->tournament_bet;
        }

        return $winningSum;
    }

    public function getActiveTournaments(Game $game, User $user)
    {
        $query = $game->tournaments()->newQuery();

        return $query->where("tournament_status", TournamentStatus::MATCHMAKING->value)
            ->where("tournament_type", TournamentType::MULTIPLAYER->value)
            ->whereDoesntHave("players", function (Builder $builder) use ($user) {
                $builder->where("user_id", $user->id);
            })
            ->get();
    }
}
