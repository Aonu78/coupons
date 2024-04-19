<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Tournaments\TournamentFinishingTrigger;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->enum('tournament_finishing_trigger', [
                TournamentFinishingTrigger::PLAYERS_COUNT->value,
                TournamentFinishingTrigger::TIME->value,
            ])->default(TournamentFinishingTrigger::PLAYERS_COUNT->value)->after('tournament_status');

            $table->timestamp("tournament_starts_at")->nullable()->after('tournament_finishing_trigger');
            $table->timestamp("tournament_ends_at")->nullable()->after('tournament_starts_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn(['tournament_finishing_trigger', 'tournament_starts_at', 'tournament_ends_at']);
        });
    }
};
