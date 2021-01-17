<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoBrindisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_brindis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto')->unsigned();
            $table->foreign('producto')->references('id')->on('productos');
            $table->bigInteger('brindi')->unsigned();
            $table->foreign('brindi')->references('id')->on('brindis');
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
        Schema::dropIfExists('producto_brindis');
    }
}
