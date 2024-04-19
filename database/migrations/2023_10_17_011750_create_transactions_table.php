<?php

use App\Enum\Finance\WalletCurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Finance\Transaction\TransactionType;
use App\Enum\Finance\Transaction\TransactionStatus;
use App\Enum\Finance\Transaction\TransactionProvider;
use App\Enum\Finance\Transaction\TransactionOperation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("transaction_uuid")->index("idx_transaction-uuid")->unique("uidx_transaction-uuid");

            $table->morphs("entity");

            $table->float("transaction_amount");
            $table->text("transaction_description");

            $table->enum("transaction_operation", [
                TransactionOperation::CREDIT->value,
                TransactionOperation::DEBIT->value,
            ])->index("idx_transaction-operation");

            $table->enum("transaction_type", [
                TransactionType::DEPOSIT->value,
                TransactionType::WITHDRAW->value,
                TransactionType::GAME->value,
                TransactionType::AFFILIATION->value,
            ])->index("idx_transaction-type");

            $table->enum("transaction_provider", [
                TransactionProvider::SYSTEM->value,
                TransactionProvider::STRIPE->value,
            ])->default(TransactionProvider::SYSTEM->value)->index("idx_transaction-provider");

            $table->enum("transaction_status", [
                TransactionStatus::PENDING->value,
                TransactionStatus::SUCCESS->value,
                TransactionStatus::FAILED->value,
            ]);

            $table->enum("transaction_currency", [
                WalletCurrency::USD->value,
                WalletCurrency::CP_TOKEN->value,
            ]);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
