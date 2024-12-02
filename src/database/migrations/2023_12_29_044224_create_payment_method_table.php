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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('currency', 20)->nullable();
            $table->decimal('percent_charge', 28, 8)->default(0);
            $table->decimal('rate', 28, 8)->default(0);
            $table->string('name', 30)->nullable();
            $table->string('code', 30)->nullable();
            $table->string('file', 190)->nullable();
            $table->json('parameter', 190)->nullable();
            $table->tinyInteger('type')->default(\App\Enums\Payment\GatewayType::AUTOMATIC->value);
            $table->tinyInteger('status')->default(\App\Enums\Payment\GatewayStatus::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
