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
        Schema::create('agent_withdraw_logs', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index()->nullable();
            $table->foreignId('withdraw_method_id');
            $table->foreignId('agent_id')->index();
            $table->string('currency')->nullable();
            $table->decimal('rate', 28,8)->default(0);
            $table->decimal('amount', 28,8)->default(0);
            $table->decimal('charge', 28,8)->default(0);
            $table->decimal('final_amount', 28,8)->default(0);
            $table->decimal('after_charge', 28,8)->default(0);
            $table->string('trx')->nullable();
            $table->json('meta')->nullable();
            $table->text('details')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Payment\Withdraw\Status::INITIATED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_withdraw_logs');
    }
};
