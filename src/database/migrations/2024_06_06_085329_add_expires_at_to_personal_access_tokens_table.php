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
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->json('investment_setting')->nullable();
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->decimal('minimum', 28, 8)->nullable();
            $table->decimal('maximum', 28, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('investment_setting');
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('minimum');
            $table->dropColumn('maximum');
        });
    }
};
