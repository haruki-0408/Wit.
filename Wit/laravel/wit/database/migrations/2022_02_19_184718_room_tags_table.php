<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_tags', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags'); //tags_tableからの外部キー参照

            $table->integer('room_id')->unsigned();
            $table->foreign('room_id')->references('id')->on('rooms'); //users_tableからの外部キー参照

            $table->primary("id")->incriment();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_tags');
    }
}
