<?php

use App\Enum\Tournaments\TournamentType;
use App\Enum\Tournaments\TournamentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('game_id');

            $table->uuid("tournament_uuid");
            $table->enum("tournament_type", [
                TournamentType::HEAD_TO_HEAD->value,
                TournamentType::MULTIPLAYER->value,
            ])->default(TournamentType::HEAD_TO_HEAD->value);

            $table->enum("tournament_status", [
                TournamentStatus::MATCHMAKING->value,
                TournamentStatus::IN_PROGRESS->value,
                TournamentStatus::FINISHED->value,
            ])->default(TournamentStatus::MATCHMAKING->value);

            $table->boolean('has_bot')->default(false);

            $table->float("tournament_bet");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
