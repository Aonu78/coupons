<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // $table->dropColumn(["discount", "sales_price"]);

            $table->date("coupon_usage_start_date")->nullable()->after("end_date");
            $table->date("coupon_usage_end_date")->nullable()->after("coupon_usage_start_date");

            $table->unsignedInteger("coupons_available")->nullable()->after("price");
            $table->boolean("coupon_rebuyible")->default(true)->after("coupons_available");

            $table->text("coupon_description")->nullable()->after("name");

            $table->renameColumn("start_date", "sale_start_date");
            $table->renameColumn("end_date", "sale_end_date");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("coupons", function (Blueprint $table) {
            $table->float('discount')->after("price");
            $table->float('sales_price')->after("discount");

            $table->renameColumn("sale_start_date", "start_date");
            $table->renameColumn("sale_end_date", "end_date");

            $table->dropColumn(
                [
                    "coupon_usage_start_date",
                    "coupon_usage_end_date",
                    "coupons_available",
                    "coupon_rebuyible",
                    "coupon_description"
                ]
            );
        });
    }
};
