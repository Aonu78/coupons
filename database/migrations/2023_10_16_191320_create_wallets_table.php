<?php

use App\Enum\Finance\WalletCurrency;
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
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("wallet_uuid")->index("idx_wallet-uuid")->unique("uidx_wallet-uuid");

            $table->morphs("holder");

            $table->enum("wallet_currency", [
                WalletCurrency::USD->value,
                WalletCurrency::CP_TOKEN->value,
            ]);

            $table->double("wallet_balance")->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
