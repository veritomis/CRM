<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre');
            $table->text('Descripción');
            $table->text('Comentario')->nullable();
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('idcaso')->nullable();
            $table->timestamps();

            $table->foreign('idcaso')->references('id')->on('casos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}
