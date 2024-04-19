<?php

use App\Enum\Finance\WithdrawStatus;
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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->uuid("withdraw_uuid")->index("idx_withdraw-uuid")->unique("uidx_withdraw-uuid");

            $table->morphs("entity");

            $table->enum("withdraw_status", [
                WithdrawStatus::PENDING->value,
                WithdrawStatus::ACCEPTED->value,
                WithdrawStatus::REJECTED->value,
            ])->default(WithdrawStatus::PENDING->value);

            $table->double("withdraw_history_amount")->default(0);

            $table->string("withdraw_target")->comment("Stripe Payment Method ID")->nullable();

            $table->string("withdraw_reject_reason")->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
