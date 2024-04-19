<?php

use App\Enum\Finance\Bank\DepositType;
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
        Schema::table('user_banks', function (Blueprint $table) {
            $table->dropColumn(['ifsc_code', 'branch_name']);

            $table->smallInteger("branch_number")->after("bank_name");
            $table->enum("deposit_type", [
                DepositType::CURRENT->value,
                DepositType::NORMAL->value,
                DepositType::SAVING->value,
            ])->after("branch_number");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_banks', function (Blueprint $table) {
            $table->string("ifsc_code")->after("bank_name");

            $table->string("branch_name")->nullable()->after("ifsc_code");

            $table->dropColumn(["branch_number", "deposit_type"]);
        });
    }
};
