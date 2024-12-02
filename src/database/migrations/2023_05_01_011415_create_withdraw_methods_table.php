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
        Schema::create('withdraw_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('currency_name', 20)->nullable();
            $table->decimal('min_limit', 28,8)->default(0);
            $table->decimal('max_limit', 28, 8)->default(0);
            $table->decimal('fixed_charge', 28, 8)->default(0);
            $table->decimal('percent_charge', 28, 8)->default(0);
            $table->decimal('rate', 28, 8)->default(0);
            $table->string('file')->nullable();
            $table->json('parameter')->nullable();
            $table->text('instruction')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Payment\Withdraw\MethodStatus::ACTIVE->value);
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
        Schema::dropIfExists('withdraw_methods');
    }
};
