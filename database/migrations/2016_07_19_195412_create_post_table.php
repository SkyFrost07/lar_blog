<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table){
            $table->increments('id');
            $table->integer('thumb_id')->references('id')->on('files')->onDelete('set null');
            $table->string('thumb_ids');
            $table->integer('author_id')->references('id')->on('users')->onDelete('set null');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('comment_status')->default(1);
            $table->integer('comment_count');
            $table->string('post_type', 30)->default('post');
            $table->integer('views');
            $table->string('template');
            $table->index(['id', 'post_type']);
            $table->timestamps();
            $table->timestamp('trashed_at');
        });
        
        Schema::create('post_desc', function(Blueprint $table){
            $table->integer('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->integer('lang_id')->references('id')->on('langs')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt');
            $table->longText('content');
            $table->text('custom');
            $table->string('meta_keyword');
            $table->text('meta_desc');
            $table->primary(['post_id', 'lang_id']);
        });
        
        Schema::create('post_tax', function(Blueprint $table){
            $table->integer('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->integer('tax_id')->references('id')->on('taxs')->onDelete('cascade');
            $table->primary(['post_id', 'tax_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_desc');
        Schema::dropIfExists('post_tax');
    }
}
