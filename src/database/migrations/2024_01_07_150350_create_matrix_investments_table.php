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
        Schema::create('matrix_investments', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 16)->index()->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('plan_id')->nullable();
            $table->string('name')->nullable();
            $table->string('trx', 90)->nullable();
            $table->decimal('price', 28, 8)->default(0);
            $table->decimal('referral_reward', 28, 8)->default(0);
            $table->decimal('referral_commissions', 28, 8)->default(0);
            $table->decimal('level_commissions', 28, 8)->default(0);
            $table->json('meta')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Matrix\InvestmentStatus::RUNNING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_investments');
    }
};
