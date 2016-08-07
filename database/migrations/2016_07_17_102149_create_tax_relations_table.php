<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_relations', function(Blueprint $table){
            $table->integer('tax_id');
            $table->integer('parent_id');
            $table->primary(['tax_id', 'parent_id']);
            $table->foreign('tax_id')->references('id')->on('taxs')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('taxs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_relations');
    }
}
