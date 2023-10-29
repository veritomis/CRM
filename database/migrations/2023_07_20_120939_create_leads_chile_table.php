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
        Schema::create('leads_chile', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
            $table->string('form_id');
            $table->string('form_name');
            $table->string('is_organic');
            $table->string('platform');
            $table->string('cuentanos_sobre_el_proyecto');
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('company_name');
            $table->string('job_title');
            $table->integer('tipificacion')->nullable(); //agregado para ver si corrigo error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads_chile');
    }
};
