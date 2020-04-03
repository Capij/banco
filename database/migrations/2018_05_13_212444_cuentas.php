<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cuentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numerocuenta',200);
            $table->double('dinero',8,2);
            $table->unsignedInteger('usersid');
            $table->foreign('usersid')->references('id')->on('users');
            $table->integer('tipocuentaid')->unsigned();
            $table->foreign('tipocuentaid')->references('id')->on('tipocuenta');
            $table->string('clave', 100); 
            $table->integer('mes');
            $table->integer('anu');
            $table->boolean('deleted');
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
        Schema::dropIfExists('cuentas');
    }
}
