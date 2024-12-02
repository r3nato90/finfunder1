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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->decimal('balance', 28, 8)->default(0);
            $table->decimal('monthly_investment', 28, 8)->default(0);
            $table->string('password');
            $table->tinyInteger('status')->default(\App\Enums\Status::ACTIVE->value);
            $table->timestamps();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->json('agent_investment_commission')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('agent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('agent_investment_commission');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('agent_id');
        });
    }
};
