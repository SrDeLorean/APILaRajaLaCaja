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
            $table->string('foto')->nulleable();
            $table->string('mensaje');
            $table->date('entrega');
            $table->string('direccion');
            $table->string('telefono');

            $table->bigInteger('estado')->unsigned();
            $table->foreign('estado')->references('id')->on('estados');
            $table->bigInteger('tipo')->unsigned();
            $table->foreign('tipo')->references('id')->on('tipos');
            
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
