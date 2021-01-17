<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketBrindisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_brindis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket')->unsigned();
            $table->foreign('ticket')->references('id')->on('tickets');
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
        Schema::dropIfExists('ticket_brindis');
    }
}
