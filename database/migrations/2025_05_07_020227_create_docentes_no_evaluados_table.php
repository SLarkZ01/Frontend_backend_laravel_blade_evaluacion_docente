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
        Schema::create('docentes_no_evaluados', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.docentes_no_evaluados\' doesn\'t exist in engine');
            $table->integer('id_docente_No_Evaluado');
            $table->integer('id_evaluacion')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_coordinacion')->nullable();
            $table->integer('id_programa')->nullable();
            $table->integer('id_curso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes_no_evaluados');
    }
};
