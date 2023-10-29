<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosTable extends Migration
{
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->timestamps();
        });

        // Inserta los estados iniciales
        DB::table('estados')->insert([
            ['estado' => 'Nuevo'],
            ['estado' => 'En seguimiento'],
            ['estado' => 'Descartado'],
            ['estado' => 'Solicita Cotización'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('estados');
    }
}

