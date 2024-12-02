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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->text('details')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->json('referral_setting')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('details');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('referral_setting');
        });
    }

};
