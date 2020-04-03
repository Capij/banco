<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Historial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numerocuenta', 200);
            $table->string('descripcion', 200);
            $table->string('numerorastreo', 200);
            $table->double('cantidad',8,2);
            $table->string('sitio',200);
            $table->string('cuentadestino',200);
            $table->integer('tipotransferenciaid')->unsigned();
            $table->foreign('tipotransferenciaid')->references('id')->on('tipotransferencia');
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
        Schema::dropIfExists('historial');
    }
}
