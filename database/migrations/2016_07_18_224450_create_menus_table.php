<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function(Blueprint $table){
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('parent_id');
            $table->tinyInteger('menu_type')->default(0);
            $table->integer('type_id');
            $table->string('icon', 64);
            $table->string('open_type', 15);
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('group_id')->references('id')->on('taxs')->onDelete('set null');
        });
        
        Schema::create('menu_desc', function(Blueprint $table){
            $table->integer('menu_id');
            $table->integer('lang_id');
            $table->string('title');
            $table->string('slug');
            $table->string('link');
            $table->primary(['menu_id', 'lang_id']);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
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
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_desc');
    }
}
