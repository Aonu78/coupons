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
        Schema::create('user_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("bank_uuid")->index("idx_bank-uuid")->unique("uidx_bank-uuid");

            $table->unsignedBigInteger('user_id');

            $table->string("account_name");
            $table->string("account_number");
            $table->string("bank_name");
            $table->string("ifsc_code");

            $table->string("branch_name")->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_banks');
    }
};
