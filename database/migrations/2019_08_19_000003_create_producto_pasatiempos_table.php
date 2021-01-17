<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoPasatiemposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_pasatiempos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto')->unsigned();
            $table->foreign('producto')->references('id')->on('productos');
            $table->bigInteger('pasatiempo')->unsigned();
            $table->foreign('pasatiempo')->references('id')->on('pasatiempos');
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
        Schema::dropIfExists('producto_pasatiempos');
    }
}
