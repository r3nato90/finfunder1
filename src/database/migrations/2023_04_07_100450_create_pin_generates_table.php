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
        Schema::create('pin_generates', function (Blueprint $table) {
            $table->id();
            $table->string('uid',32)->index();
            $table->foreignId('user_id')->index()->nullable();
            $table->foreignId('set_user_id')->index()->nullable();
            $table->decimal('amount', 28,8)->default(0);
            $table->string('pin_number', 120)->nullable();
            $table->string('details')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\Matrix\PinStatus::UNUSED->value)->comment('Unused : 1, Used : 0');
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
        Schema::dropIfExists('pin_generates');
    }
};
