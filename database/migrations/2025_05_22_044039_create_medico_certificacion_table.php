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
        Schema::create('medico_certificacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_medico');
            $table->foreign('id_medico')->references('id')->on('medicos')->onDelete('cascade');
            $table->unsignedBigInteger('id_certificacion');
            $table->foreign('id_certificacion')->references('id')->on('certificaciones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medico_certificacion');
    }
};
