<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->char('id',26)->primary(); //RoomのIDだけはULID
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete()->comment('users_tableからの外部キー参照');
            $table->string('title', 30);
            $table->string('description', 400);
            $table->string('password')->nullable()->default(null);
            $table->dateTime('created_at')->useCurrent(); 
            $table->dateTime('posted_at')->nullable()->default(null); 
        });

        DB::statement('ALTER TABLE `rooms` ADD INDEX `room_desc_index` (id DESC,user_id DESC,title DESC,description DESC,password DESC,created_at DESC,posted_at DESC)');

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
