<?php

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
        Schema::create('categories_games', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger("category_id");
            $table->unsignedInteger("game_id");

            $table->timestamps();

            $table->index(["game_id", "category_id"], "idx_game-id_category-id");
            $table->unique(["game_id", "category_id"], "uidx_game-id_category-id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_games');
    }
};
