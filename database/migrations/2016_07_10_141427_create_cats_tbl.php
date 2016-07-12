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
           $table->integer('image_id')->references('id')->on('files')->onDelete('set default');
           $table->string('type', 30)->default('cat');
           $table->integer('parent_id')->default(0)->references('id')->on('taxs')->onDelete('set default');
           $table->integer('order');
           $table->integer('count');
           $table->integer('status')->default(1);
           $table->timestamps();
        });
        
        Schema::create('tax_desc', function(Blueprint $table){
           $table->integer('tax_id')->references('id')->on('taxs')->onDelete('cascade');
           $table->integer('lang_id')->references('id')->on('langs')->onDelete('cascade');
           $table->string('name');
           $table->string('slug');
           $table->string('description');
           $table->primary(['tax_id', 'lang_id']);
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
        Schema::dropIfExists('taxs');
        Schema::dropIfExists('tax_desc');
    }
}
