<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxs', function(Blueprint $table){
           $table->increments('id');
           $table->integer('image_id');
           $table->string('type', 30)->default('cat');
           $table->integer('parent_id');
           $table->integer('order');
           $table->integer('count');
           $table->integer('status')->default(1);
           $table->timestamps();
        });
        
        Schema::create('tax_desc', function(Blueprint $table){
           $table->integer('tax_id');
           $table->integer('lang_id');
           $table->string('name');
           $table->string('slug');
           $table->text('description', 500);
           $table->string('meta_keyword', 255);
           $table->text('meta_desc', 500);
           $table->primary(['tax_id', 'lang_id']);
           $table->timestamps();
           $table->foreign('tax_id')->references('id')->on('taxs')->onDelete('cascade');
           $table->foreign('lang_id')->references('id')->on('langs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxs');
        Schema::dropIfExists('tax_desc');
    }
}
