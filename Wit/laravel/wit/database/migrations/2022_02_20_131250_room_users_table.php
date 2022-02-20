<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomUsersTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete()->comment('users_tableからの外部キー参照');
            $table->foreignId('room_id')->references('id')->on('rooms')->cascadeOnUpdate()->cascadeOnDelete()->comment('rooms_tableからの外部キー参照');
            $table->dateTime('entered_at')->useCurrent();
            $table->dateTime('exited_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_users');
    }
}
