<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RoomImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->references('id')->on('rooms')->cascadeOnUpdate()->cascadeOnDelete()->comment('rooms_tableからの外部キー参照');
            $table->string('image')->comment('画像ファイルのパス'); 
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_images');
    }
}
