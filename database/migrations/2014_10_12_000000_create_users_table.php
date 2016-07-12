<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->tinyInteger('gender');
            $table->timestamp('birth');
            $table->integer('image_id', 0)->references('id')->on('files')->onDelete('set default');
            $table->tinyInteger('status')->default(2);
            $table->string('resetPasswdToken');
            $table->bigInteger('resetPasswdExpires');
            $table->rememberToken();
            $table->timestamps();
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
