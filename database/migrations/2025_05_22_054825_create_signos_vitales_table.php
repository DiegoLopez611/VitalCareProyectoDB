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
        Schema::create('signos_vitales', function (Blueprint $table) {
            $table->id();
            $table->integer('pulso');
            $table->integer('frecuencia_cardiaca');
            $table->integer('frecuencia_respiratoria');
            $table->decimal('temperatura',4,1);
            $table->decimal('oximetria',4,1);
            $table->decimal('grasa_viceral',5,2);
            $table->decimal('grasa_total',5,2);
            $table->decimal('masa_muscular',6,2);
            $table->decimal('agua_corporal',5,2);
            $table->integer('edad_metabolica');
            $table->unsignedBigInteger('id_historia_clinica');
            $table->foreign('id_historia_clinica')->references('id')->on('historias_clinicas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signos_vitales');
    }
};
