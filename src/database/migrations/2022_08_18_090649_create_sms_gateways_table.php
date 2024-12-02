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
        Schema::create('sms_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique()->index();
            $table->string('name', 60)->nullable();
            $table->text('credential')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\SMS\SmsGatewayStatus::ACTIVE->value)->comment('Active : 1, Inactive : 0');
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
        Schema::dropIfExists('sms_gateways');
    }
};
