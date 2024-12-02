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
        Schema::create('matrix', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 32)->index();
            $table->string('name', 90);
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('referral_reward', 28, 8)->default(0);
            $table->boolean('is_recommend')->default(0);
            $table->tinyInteger('status')->default(\App\Enums\Matrix\PlanStatus::DISABLE->value);
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
        Schema::dropIfExists('matrix');
    }
};
