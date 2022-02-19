<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users'); //users_tableからの外部キー参照

            $table->integer('favorite_user_id')->unsigned();
            $table->foreign('favorite_user_id')->references('id')->on('users'); //users_tableからの外部キー参照

            $table->primary("id")->incriment();
            $table->dateTime('created_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_users');
    }
}
