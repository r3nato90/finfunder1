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
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('post_balance', 28, 8)->default(0);
            $table->decimal('charge', 28, 8)->default(0);
            $table->string('trx',60)->nullable();
            $table->tinyInteger('type')->default(\App\Enums\Transaction\Type::PLUS->value);
            $table->tinyInteger('wallet_type')->default(\App\Enums\Transaction\WalletType::PRIMARY->value);
            $table->tinyInteger('source')->default(\App\Enums\Transaction\Source::ALL->value);
            $table->string('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
