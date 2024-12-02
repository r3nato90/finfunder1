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
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('btc_wallet')->nullable();
            $table->decimal('btc_amount', 28, 8)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('btc_wallet');
            $table->dropColumn('btc_amount');
        });
    }
};
