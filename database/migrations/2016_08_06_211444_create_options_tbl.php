<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function(Blueprint $table){
            $table->string('option_key');
            $table->string('lang_code', 2);
            $table->string('label');
            $table->text('value');
            $table->foreign('lang_code')->references('code')->on('langs')->onDelete('cascade');
            $table->primary(['key', 'lang_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
