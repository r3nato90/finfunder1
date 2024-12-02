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
        Schema::table('investment_plans', function (Blueprint $table) {
            $table->tinyInteger('interest_type')->default(\App\Enums\Investment\InterestType::PERCENT->value);
            $table->foreignId('time_id')->nullable();
            $table->tinyInteger('interest_return_type')->default(\App\Enums\Investment\ReturnType::LIFETIME->value);
            $table->tinyInteger('recapture_type')->default(\App\Enums\Investment\Recapture::YES->value);
            $table->integer('duration')->nullable()->change();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->json('holiday_setting')->nullable();
        });

        Schema::table('commissions', function (Blueprint $table) {
            $table->integer('investment_log_id')->nullable();
        });

        Schema::table('investment_logs', function (Blueprint $table) {
            $table->integer('period')->nullable();
            $table->string('time_table_name')->nullable();
            $table->integer('hours')->nullable();
            $table->timestamp('profit_time')->nullable();
            $table->timestamp('last_time')->nullable();
            $table->decimal('should_pay', 28, 8)->nullable();
            $table->tinyInteger('recapture_type')->nullable();
            $table->integer('return_duration_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investment_plans', function (Blueprint $table) {
            $table->dropColumn('interest_type');
            $table->dropColumn('time_id');
            $table->dropColumn('interest_return_type');
            $table->dropColumn('recapture_type');
            $table->dropColumn('duration');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('holiday_setting');
        });

        Schema::table('commissions', function (Blueprint $table) {
            $table->dropColumn('investment_log_id');
        });

        Schema::table('investment_logs', function (Blueprint $table) {
            $table->dropColumn('period');
            $table->dropColumn('time_table_name');
            $table->dropColumn('hours');
            $table->dropColumn('profit_time');
            $table->dropColumn('last_time');
            $table->dropColumn('should_pay');
            $table->dropColumn('recapture_type');
            $table->dropColumn('return_duration_count');
        });
    }
};
