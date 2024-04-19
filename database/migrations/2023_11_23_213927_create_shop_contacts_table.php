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
        Schema::create('shop_contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid("contact_uuid");

            $table->unsignedBigInteger("shop_id");

            $table->string("contact_name");
            $table->string("contact_name_furigana");

            $table->string("contact_phone_number")->nullable();
            $table->string("shop_url")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_contacts');
    }
};
