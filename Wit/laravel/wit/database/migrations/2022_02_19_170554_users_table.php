<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',25)->nullable()->index();
            $table->string('email')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('email_verified_token')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('profile_message',500)->nullable();
            $table->string('profile_image')->default('userImages/default/wit.PNG');
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
        Schema::dropIfExists('users');
    }
}
