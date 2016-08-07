<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function(Blueprint $table){
           $table->increments('id');
           $table->string('name');
           $table->string('url');
           $table->string('rand_dir')->unique();
           $table->string('type')->default('image');
           $table->string('mimetype');
           $table->integer('author_id');
           $table->timestamps();
           $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
