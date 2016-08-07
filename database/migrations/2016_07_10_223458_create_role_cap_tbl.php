<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleCapTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('roles', function(Blueprint $table){
           $table->increments('id');
           $table->string('label');
           $table->string('name');
           $table->tinyInteger('default')->default(0);
           $table->timestamps();
       });
       
       Schema::table('users', function(Blueprint $table){
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
       });
       
       Schema::create('caps', function(Blueprint $table){
           $table->increments('id');
           $table->string('name');
           $table->string('label');
           $table->string('higher')->references('name')->on('caps')->onDelete('set null');
           $table->timestamps();
       });
       
       Schema::create('role_cap', function(Blueprint $table){
           $table->integer('role_id');
           $table->integer('cap_id');
           $table->primary(['role_id', 'cap_id']);
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
           $table->foreign('cap_id')->references('id')->on('caps')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('caps');
        Schema::dropIfExists('role_cap');
    }
}
