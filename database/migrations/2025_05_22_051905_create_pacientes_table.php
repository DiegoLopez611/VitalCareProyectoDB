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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->date('fecha_nacimiento');
            $table->string('email');
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('id_ciudad');
            $table->foreign('id_ciudad')->references('id')->on('ciudades')->onDelete('cascade');
            $table->unsignedBigInteger('id_genero');
            $table->foreign('id_genero')->references('id')->on('generos')->onDelete('cascade');
            $table->unsignedBigInteger('id_grupo_sanguineo');
            $table->foreign('id_grupo_sanguineo')->references('id')->on('grupos_sanguineos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
