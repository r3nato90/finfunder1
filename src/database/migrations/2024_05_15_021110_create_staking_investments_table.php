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
        Schema::create('staking_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('staking_plan_id');
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('interest')->default(0);
            $table->timestamp('expiration_date')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Investment\Staking\Status::RUNNING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staking_investments');
    }
};
