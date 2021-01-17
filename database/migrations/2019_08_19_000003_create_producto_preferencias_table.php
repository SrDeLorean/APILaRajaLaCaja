<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoPreferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_preferencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto')->unsigned();
            $table->foreign('producto')->references('id')->on('productos');
            $table->bigInteger('preferencia')->unsigned();
            $table->foreign('preferencia')->references('id')->on('preferencias');
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
        Schema::dropIfExists('producto_preferencias');
    }
}
