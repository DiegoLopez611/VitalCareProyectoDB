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
        Schema::create('medidas_corporales', function (Blueprint $table) {
            $table->id();
            $table->string('zona');
            $table->decimal('medida',4,1);
            $table->unsignedBigInteger('id_registro_antropometrico');
            $table->foreign('id_registro_antropometrico')->references('id')->on('registros_antropometricos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medidas_corporales');
    }
};
