<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto', function (Blueprint $table) {
            $table->id();
            $table->integer('id_Proyecto')->nullable();
            $table->integer('idconsulta')->nullable();
            $table->string('T_implementaciOn', 250)->nullable();
            $table->string('Testing', 250)->nullable();
            $table->string('Costo_Total', 250)->nullable();
            $table->string('nombre_proyecto', 255)->nullable();
            $table->string('descripcion_proyecto', 800)->nullable();
            $table->integer('cantidad_modulos')->nullable();
            $table->string('nombre_modulo', 255)->nullable();
            $table->string('descripcion_modulo', 800)->nullable();
            $table->integer('cantidad_procesos')->nullable();

            for ($i = 1; $i <= 10; $i++) {
                $table->string("nombre_proceso_$i", 255)->nullable();
                $table->string("descripcion_proceso_$i", 800)->nullable();
            }

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
        Schema::dropIfExists('proyecto');
    }
}
