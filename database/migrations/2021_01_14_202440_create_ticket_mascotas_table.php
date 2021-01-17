<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketMascotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_mascotas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket')->unsigned();
            $table->foreign('ticket')->references('id')->on('tickets');
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
        Schema::dropIfExists('ticket_mascotas');
    }
}
