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
        Schema::create('registros_antropometricos', function (Blueprint $table) {
            $table->id();
            $table->decimal('peso',5,2);
            $table->decimal('altura',4,2);
            $table->decimal('imc',4,2)->nullable();
            $table->decimal('peso_meta',5,2)->nullable();
            $table->decimal('gasto_calorico',6,2)->nullable();
            $table->unsignedBigInteger('id_historia_clinica');
            $table->foreign('id_historia_clinica')->references('id')->on('historias_clinicas')->onDelete('cascade');
            $table->unsignedBigInteger('id_interpretacion_imc')->nullable;
            $table->foreign('id_interpretacion_imc')->references('id')->on('interpretaciones_imc')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_antropometricos');
    }
};
