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
        Schema::create('facturas_atenciones', function (Blueprint $table) {
            $table->id();
            $table->integer('valor_neto');
            $table->integer('descuento');
            $table->date('fecha_vencimiento');
            $table->date('periodo_fecha_inicio');
            $table->date('periodo_fecha_final');
            $table->unsignedBigInteger('id_paciente');
            $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas_atenciones');
    }
};
