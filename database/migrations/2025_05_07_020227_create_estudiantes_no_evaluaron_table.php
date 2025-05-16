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
        Schema::create('estudiantes_no_evaluaron', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.estudiantes_no_evaluaron\' doesn\'t exist in engine');
            $table->integer('id_estudiante');
            $table->integer('id_programa')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_curso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes_no_evaluaron');
    }
};
