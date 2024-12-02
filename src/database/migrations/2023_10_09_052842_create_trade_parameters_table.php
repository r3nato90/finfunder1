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
        Schema::create('trade_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('time')->nullable();
            $table->string('unit')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Trade\TradeParameterStatus::ACTIVE->value);
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
        Schema::dropIfExists('trade_parameters');
    }
};
