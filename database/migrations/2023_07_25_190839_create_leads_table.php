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
    Schema::create('leads_argentina', function (Blueprint $table) {
        $table->id();
        $table->string('CAMPAIGN_NAME');
        $table->string('FORM_ID');
        $table->string('FORM_NAME');
        $table->boolean('IS_ORGANIC');
        $table->string('PLATFORM');
        $table->text('CONTANOS_MÁS_SOBRE_EL_PROYECTO');
        $table->string('FULL_NAME');
        $table->string('WORK_PHONE_NUMBER');
        $table->string('WORK_EMAIL');
        $table->string('JOB_TITLE');
        $table->string('NOMBRE_DE_LA_EMPRESA');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_argentina');
    }
};
