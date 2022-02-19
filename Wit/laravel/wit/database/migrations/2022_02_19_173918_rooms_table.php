<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->$table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users'); //users_tableからの外部キー参照

        $table->primary("id")->incriment();
        $table->string('title',30);
        $table->string('description',400);
        $table->dateTime('created_at')->useCurrent();
        $table->dateTime('updated_at')->useCurrent()->nullable();
        $table->softDeletes();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
