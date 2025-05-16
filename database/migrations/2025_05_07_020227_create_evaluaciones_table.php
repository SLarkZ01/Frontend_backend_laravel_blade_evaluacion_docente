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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.evaluaciones\' doesn\'t exist in engine');
            $table->integer('id_evaluacion');
            $table->integer('id_docente')->nullable();
            $table->integer('id_curso')->nullable();
            $table->integer('id_periodo')->nullable();
            $table->decimal('autoevaluacion', 3)->nullable();
            $table->decimal('evaluacion_decano', 3)->nullable();
            $table->decimal('evaluacion_estudiantes', 3)->nullable();
            $table->decimal('promedio_total', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
