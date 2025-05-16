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
        Schema::create('promedio_evaluacion_docente_por_curso', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.promedio_evaluacion_docente_por_curso\' doesn\'t exist in engine');
            $table->integer('id_promedio');
            $table->integer('id_curso')->nullable();
            $table->integer('id_docente')->nullable();
            $table->decimal('promedio_ev_docente', 3)->nullable();
            $table->decimal('promedio_notas_curso', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promedio_evaluacion_docente_por_curso');
    }
};
