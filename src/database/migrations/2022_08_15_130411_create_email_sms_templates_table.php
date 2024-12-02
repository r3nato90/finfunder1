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
        Schema::create('email_sms_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code', 120)->unique()->index();
            $table->string('name', 120)->unique()->nullable();
            $table->string('subject')->nullable();
            $table->string('from_email', 90)->nullable();
            $table->text('mail_template')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('short_key')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Status::INACTIVE->value)->comment('Active : 1, Inactive : 0');
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
        Schema::dropIfExists('email_sms_templates');
    }
};
