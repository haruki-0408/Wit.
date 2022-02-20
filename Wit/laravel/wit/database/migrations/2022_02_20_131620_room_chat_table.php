<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_chat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->references('id')->on('rooms')->cascadeOnUpdate()->cascadeOnDelete()->comment('rooms_tableからの外部キー参照');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete()->comment('users_tableからの外部キー参照');
            $table->string('message'); //内容
            $table->string('postfile')->nullable(); //投稿ファイルのパス
            $table->dateTime('created_at')->useCurrent();
            $table->softDeletes(); //論理削除のためのdeleted_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_chat');
    }
}
