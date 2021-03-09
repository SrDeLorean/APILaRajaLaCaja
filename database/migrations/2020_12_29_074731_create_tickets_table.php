<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('receptor');
            $table->string('emisor');
            $table->date('nacimiento');
            $table->string('color');
            $table->string('excepcion');
            $table->boolean('pyme');
            $table->string('foto')->nullable();
            $table->string('mensaje');
            $table->date('entrega');
            $table->string('region');
            $table->string('comuna');
            $table->string('direccion');
            $table->string('telefono');
            $table->integer('valor');
            $table->integer('cantidadProducto');

            $table->bigInteger('motivo')->unsigned();
            $table->foreign('motivo')->references('id')->on('motivos');
            $table->bigInteger('estado')->unsigned();
            $table->foreign('estado')->references('id')->on('estados');
            $table->bigInteger('tipoCaja')->unsigned();
            $table->foreign('tipoCaja')->references('id')->on('tipo_cajas');
            $table->bigInteger('tipoPersona')->unsigned();
            $table->foreign('tipoPersona')->references('id')->on('tipo_personas');
            
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
        Schema::dropIfExists('tickets');
    }
}
