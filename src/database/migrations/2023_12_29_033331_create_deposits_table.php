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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('payment_gateway_id');
            $table->decimal('rate', 28,8)->default(0);
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->decimal('final_amount', 28, 8)->default(0);
            $table->string('trx')->nullable();
            $table->json('meta')->nullable();
            $table->tinyInteger('wallet_type')->default(\App\Enums\Transaction\WalletType::PRIMARY->value);
            $table->tinyInteger('status')->default(\App\Enums\Payment\Deposit\Status::INITIATED->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
