<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket')->unsigned();
            $table->foreign('ticket')->references('id')->on('tickets');
            $table->bigInteger('producto')->unsigned();
            $table->foreign('producto')->references('id')->on('productos');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->integer('total');
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
        Schema::dropIfExists('detalle_tickets');
    }
}
