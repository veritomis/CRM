<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesDiariosTable extends Migration
{
    public function up()
    {
        Schema::create('reportes_diarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idcaso');
            $table->text('descripcion');
            $table->date('fecha');
            $table->timestamps();
            
            // Definir claves foráneas si es necesario
            // $table->foreign('iduser')->references('id')->on('users');
            // $table->foreign('idcaso')->references('id')->on('casos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes_diarios');
    }
}
