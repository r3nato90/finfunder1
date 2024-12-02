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
    public function up()
    {
        Schema::create('trade_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('crypto_currency_id')->nullable();
            $table->decimal('original_price', 28, 8)->default(0);
            $table->decimal('amount', 28, 8)->default(0);
            $table->integer('duration')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->tinyInteger('type')->default(\App\Enums\Trade\TradeType::TRADE->value);
            $table->tinyInteger('volume')->default(\App\Enums\Trade\TradeVolume::HIGH->value);
            $table->tinyInteger('outcome')->default(\App\Enums\Trade\TradeOutcome::DRAW->value);
            $table->tinyInteger('status')->default(\App\Enums\Trade\TradeStatus::RUNNING->value);
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_logs');
    }
};
