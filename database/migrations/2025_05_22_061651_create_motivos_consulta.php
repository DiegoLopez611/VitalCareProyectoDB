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
        Schema::create('motivos_consulta', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->unsignedBigInteger('id_atencion');
            $table->foreign('id_atencion')->references('id')->on('atenciones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motivos_consulta');
    }
};
