<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoMascotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_mascotas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto')->unsigned();
            $table->foreign('producto')->references('id')->on('productos');
            $table->bigInteger('mascota')->unsigned();
            $table->foreign('mascota')->references('id')->on('mascotas');
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
        Schema::dropIfExists('producto_mascotas');
    }
}
