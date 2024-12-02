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
        Schema::create('investment_user_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 90);
            $table->string('level', 90);
            $table->decimal('invest', 18,8)->default(0);
            $table->decimal('team_invest', 18,8)->default(0);
            $table->decimal('deposit', 18,8)->default(0);
            $table->decimal('referral_count', 18,8)->default(0);
            $table->decimal('reward', 18,8)->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->decimal('aggregate_investment', 28, 8)->default(0);
            $table->decimal('collective_investment', 28, 8)->default(0);
            $table->timestamp('last_reward_update')->nullable();
            $table->integer('reward_identifier')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_user_rewards');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('aggregate_investment');
            $table->dropColumn('collective_investment');
            $table->dropColumn('last_reward_update');
            $table->dropColumn('reward_identifier');
        });
    }
};
