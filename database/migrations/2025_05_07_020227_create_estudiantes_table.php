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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.estudiantes\' doesn\'t exist in engine');
            $table->integer('id_estudiante');
            $table->string('nombre', 50)->nullable();
            $table->string('correo', 50)->nullable();
            $table->integer('semestre')->nullable();
            $table->integer('id_programa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
