<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users2', function (Blueprint $table) {
            $table->primary("id")->incriment();
            $table->string('name',20);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_message',500);
            $table->string('profile_image'); //画像のパスファイル
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->nullable();
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
        Schema::dropIfExists('users2');
    }
}
