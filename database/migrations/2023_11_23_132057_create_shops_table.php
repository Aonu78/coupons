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
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("shop_uuid");

            $table->unsignedBigInteger("user_id");

            $table->string("shop_name");
            $table->string("shop_name_furigana");

            $table->text("shop_pr")->nullable();
            $table->string("shop_logo")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
