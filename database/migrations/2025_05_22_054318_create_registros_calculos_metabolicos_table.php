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
        Schema::create('registros_calculos_metabolicos', function (Blueprint $table) {
            $table->id();
            $table->decimal('creatina_serica',5,2)->nullable();
            $table->decimal('trigliceridos',5,1)->nullable();
            $table->decimal('depcr24',5,1)->nullable();
            $table->decimal('hba1c',4,2)->nullable();
            $table->decimal('hld',5,1)->nullable();
            $table->integer('tas')->nullable();
            $table->integer('tad')->nullable();
            $table->decimal('colesterol_total',5,1)->nullable();
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
        Schema::dropIfExists('registros_calculos_metabolicos');
    }
};
