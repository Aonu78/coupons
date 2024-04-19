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
        Schema::create('shop_locations', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("location_uuid");

            $table->unsignedBigInteger("shop_id");

            $table->string("shop_postal_code");
            $table->string("shop_prefecture");
            $table->string("shop_address");
            $table->string("shop_building_number")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_locations');
    }
};
