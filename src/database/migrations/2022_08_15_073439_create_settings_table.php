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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('sms_gateway_id')->nullable();
            $table->json('logo')->nullable();
            $table->json('appearance')->nullable();
            $table->json('matrix_parameters')->nullable();
            $table->json('system_configuration')->nullable();
            $table->json('theme_setting')->nullable();
            $table->json('recaptcha_setting')->nullable();
            $table->json('seo_setting')->nullable();
            $table->json('mail_configuration')->nullable();
            $table->json('social_login')->nullable();
            $table->json('commissions_charge')->nullable();
            $table->json('crypto_api')->nullable();
            $table->json('kyc_configuration')->nullable();
            $table->json('security')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('mail_template')->nullable();
            $table->string('version')->nullable();
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
        Schema::dropIfExists('settings');
    }
};
