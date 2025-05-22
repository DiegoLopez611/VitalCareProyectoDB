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
        Schema::create('antecedentes', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->unsignedBigInteger('id_historia_clinica');
            $table->foreign('id_historia_clinica')->references('id')->on('historias_clinicas')->onDelete('cascade');
            $table->unsignedBigInteger('id_tipo_antecedente');
            $table->foreign('id_tipo_antecedente')->references('id')->on('tipos_antecedentes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes');
    }
};
