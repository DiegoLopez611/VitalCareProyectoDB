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
        Schema::create('informes_diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->string('justificacion');
            
            $table->unsignedBigInteger('id_tipo_diagnostico');
            $table->foreign('id_tipo_diagnostico')->references('id')->on('tipos_diagnosticos')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_atencion');
            $table->foreign('id_atencion')->references('id')->on('atenciones')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_historia_clinica');
            $table->foreign('id_historia_clinica')->references('id')->on('historias_clinicas')->onDelete('cascade');

            $table->unsignedBigInteger('id_diagnostico');
            $table->foreign('id_diagnostico')->references('id')->on('diagnosticos')->onDelete('cascade');

            $table->unsignedBigInteger('id_tratamiento');
            $table->foreign('id_tratamiento')->references('id')->on('tratamientos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes_diagnosticos');
    }
};
