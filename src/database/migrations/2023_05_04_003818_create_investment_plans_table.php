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
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 16)->index();
            $table->string('name');
            $table->decimal('minimum', 28, 8)->default(0);
            $table->decimal('maximum', 28, 8)->default(0);
            $table->decimal('amount', 28, 8)->default(0);
            $table->decimal('interest_rate', 10,2)->default(0);
            $table->integer('duration')->nullable()->default(1);
            $table->json('meta')->nullable();
            $table->longText('terms_policy')->nullable();
            $table->boolean('is_recommend')->default(false);
            $table->tinyInteger('type')->default(\App\Enums\Investment\InvestmentRage::RANGE->value);
            $table->tinyInteger('status')->default(\App\Enums\Matrix\PlanStatus::ENABLE->value);
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
        Schema::dropIfExists('investment_plans');
    }
};
