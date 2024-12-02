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
        Schema::create('investment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 16)->index();
            $table->foreignId('user_id')->index();
            $table->foreignId('investment_plan_id')->nullable();
            $table->string('plan_name')->nullable();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('interest_rate', 28, 8)->default(0);
            $table->decimal('profit',28, 8)->default(0);
            $table->string('trx', 90)->nullable();
            $table->boolean('is_reinvest')->default(false);
            $table->tinyInteger('status')->default(\App\Enums\Investment\Status::INITIATED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_logs');
    }
};
