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
        Schema::create('atenciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->unsignedBigInteger('id_estado_atencion');
            $table->foreign('id_estado_atencion')->references('id')->on('estados_atencion')->onDelete('cascade');
            $table->unsignedBigInteger('id_especialidad');
            $table->foreign('id_especialidad')->references('id')->on('especialidades')->onDelete('cascade');
            $table->integer('duracion');
            $table->time('hora');
            $table->unsignedBigInteger('id_medico');
            $table->foreign('id_medico')->references('id')->on('medicos')->onDelete('cascade');
            $table->unsignedBigInteger('id_paciente');
            $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->unsignedBigInteger('id_factura_atencion')->nullable();
            $table->foreign('id_factura_atencion')->references('id')->on('facturas_atenciones')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atenciones');
    }
};
