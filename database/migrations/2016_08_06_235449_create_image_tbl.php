<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function(Blueprint $table){
            $table->increments('id');
            $table->string('thumb_url');
            $table->string('thumb_type', 30)->default('image');
            $table->integer('author_id');
            $table->tinyInteger('status')->default(1);
            $table->integer('views');
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        });
        
        Schema::create('image_desc', function(Blueprint $table){
            $table->integer('image_id');
            $table->string('lang_code', 2);
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->primary(['image_id', 'lang_code']);
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('lang_code')->references('code')->on('langs')->onDelete('cascade');
        });
        
        Schema::create('image_tax', function(Blueprint $table){
            $table->integer('image_id');
            $table->integer('tax_id');
            $table->primary(['image_id', 'tax_id']);
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('tax_id')->references('id')->on('taxs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('image_desc');
        Schema::dropIfExists('image_tax');
    }
}
