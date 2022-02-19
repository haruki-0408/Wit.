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
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users'); //users_tableからの外部キー参照

            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms'); //rooms_tableからの外部キー参照

            $table->primary("id")->incriment();
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
