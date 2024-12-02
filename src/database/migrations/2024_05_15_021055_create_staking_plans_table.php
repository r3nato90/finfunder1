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
        Schema::create('staking_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('duration')->default(0);
            $table->decimal('interest_rate')->default(0);
            $table->decimal('minimum_amount', 28, 8)->default(0);
            $table->decimal('maximum_amount', 28, 8)->default(0);
            $table->tinyInteger('status')->default(\App\Enums\Status::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staking_plans');
    }
};
