<?php

use App\Enums\User\UserActivationStatus;
use App\Enums\User\EmailVerifiedStatus;
use App\Enums\User\Status;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('first_name', 90)->nullable();
            $table->string('last_name', 90)->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->integer('referral_by')->nullable();
            $table->integer('position_id')->nullable();
            $table->integer('position')->nullable();
            $table->string('email', 90)->unique();
            $table->string('phone', 20)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('kyc_status')->default(\App\Enums\User\KycStatus::ACTIVE->value);
            $table->tinyInteger('status')->default(Status::ACTIVE->value)->comment('Active : 1, Banned : 0');
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('users');
    }
};
