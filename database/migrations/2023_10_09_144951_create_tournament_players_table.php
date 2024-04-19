<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Tournaments\Players\PlayerStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid("player_uuid");

            $table->unsignedBigInteger("tournament_id");
            $table->unsignedBigInteger("user_id");

            $table->enum("player_status", [
                PlayerStatus::MATCHMAKING->value,
                PlayerStatus::IN_GAME->value,
                PlayerStatus::GAME_FINISHED->value,
                PlayerStatus::LEAVED->value,
                PlayerStatus::TOURNAMENT_FINISHED->value
            ])->default(PlayerStatus::MATCHMAKING->value);

            $table->float("player_score")->nullable();
            $table->boolean("is_winner")->default(false);
            $table->boolean("is_bot")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_players');
    }
};
