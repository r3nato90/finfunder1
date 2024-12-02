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
        Schema::create('agent_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->index();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('post_balance', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->string('trx',60)->nullable();
            $table->tinyInteger('type')->default(\App\Enums\Transaction\Type::PLUS->value);
            $table->string('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_transactions');
    }
};
