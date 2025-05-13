<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->integer('id_evaluacion')->primary();
            $table->integer('id_docente')->nullable();
            $table->integer('id_curso')->nullable();
            $table->integer('id_periodo')->nullable();
            $table->decimal('autoevaluacion', 3, 2)->nullable();
            $table->decimal('evaluacion_decano', 3, 2)->nullable();
            $table->decimal('evaluacion_estudiantes', 3, 2)->nullable();
            $table->decimal('promedio_total', 3, 2)->nullable();
            
            $table->foreign('id_docente', 'evaluaciones_ibfk_1')->references('id_docente')->on('docente');
            $table->foreign('id_curso', 'evaluaciones_ibfk_2')->references('id_curso')->on('cursos');
            $table->foreign('id_periodo', 'evaluaciones_ibfk_3')->references('id_periodo')->on('periodos_academicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones');
    }
}
