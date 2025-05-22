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
        Schema::create('detalles_prescripciones', function (Blueprint $table) {
            $table->id();
            $table->integer('duracion');
            $table->string('indicacion');
            $table->integer('frecuencia');
            $table->string('dosis');
            $table->unsignedBigInteger('id_tratamiento');
            $table->foreign('id_tratamiento')->references('id')->on('tratamientos')->onDelete('cascade');
            $table->unsignedBigInteger('id_medicamento');
            $table->foreign('id_medicamento')->references('id')->on('medicamentos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_prescripciones');
    }
};
