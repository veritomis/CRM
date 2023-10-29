<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acciones_argentina', function (Blueprint $table) {
            $table->id();
            $table->string('accion');
            $table->string('descripcion');
            $table->string('comentario')->nullable();
            $table->text('documento1')->nullable();
            $table->text('documento2')->nullable();
            $table->unsignedBigInteger('usuario');
            $table->unsignedBigInteger('lead');
            $table->timestamps();
            $table->foreign('usuario')->references('id')->on('usuarios');
            $table->foreign('lead')->references('id')->on('leads_argentina');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_argentina');
    }
};
