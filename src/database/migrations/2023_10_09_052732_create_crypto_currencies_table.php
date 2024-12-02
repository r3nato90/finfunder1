<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('crypto_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 190);
            $table->string('pair', 190);
            $table->string('crypto_id', 190);
            $table->text('file')->nullable();
            $table->string('symbol', 20);
            $table->tinyInteger('status')->default(\App\Enums\Trade\CryptoCurrencyStatus::ACTIVE->value);
            $table->tinyInteger('top_gainer')->nullable();
            $table->tinyInteger('top_loser')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_currencies');
    }
};
