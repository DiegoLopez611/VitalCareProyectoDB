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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('direccion');
            $table->date('fecha_nacimiento');
            $table->string('password');
            $table->unsignedBigInteger('id_estado_usuario');
            $table->foreign('id_estado_usuario')->references('id')->on('estados_usuario')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
