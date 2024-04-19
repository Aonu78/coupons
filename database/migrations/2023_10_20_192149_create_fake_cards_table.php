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
        Schema::create('fake_cards', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id");

            $table->text("card_number");
            $table->text("card_cvc");
            $table->unsignedSmallInteger("card_exp_month");
            $table->year("card_exp_year");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_cards');
    }
};
