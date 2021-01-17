<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketPreferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_preferencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket')->unsigned();
            $table->foreign('ticket')->references('id')->on('tickets');
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
        Schema::dropIfExists('ticket_preferencias');
    }
}
