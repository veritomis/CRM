<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gastos_variables', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2); // Cambia la precisión según tus necesidades
            $table->text('descripcion');
            $table->unsignedBigInteger('proyecto_id');
            $table->string('nombre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos_variables');
    }
};
