<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketPasaTiemposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_pasa_tiempos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket')->unsigned();
            $table->foreign('ticket')->references('id')->on('tickets');
            $table->bigInteger('pasaTiempo')->unsigned();
            $table->foreign('pasaTiempo')->references('id')->on('pasatiempos');
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
        Schema::dropIfExists('ticket_pasa_tiempos');
    }
}
