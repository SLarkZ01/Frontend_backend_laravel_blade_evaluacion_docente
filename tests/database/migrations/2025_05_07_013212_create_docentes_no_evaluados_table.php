<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocentesNoEvaluadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docentes_no_evaluados', function (Blueprint $table) {
            $table->integer('id_docente_No_Evaluado')->primary();
            $table->integer('id_evaluacion')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_coordinacion')->nullable();
            $table->integer('id_programa')->nullable();
            $table->integer('id_curso')->nullable();
            
            $table->foreign('id_evaluacion', 'docentes_no_evaluados_ibfk_1')->references('id_evaluacion')->on('evaluaciones');
            $table->foreign('id_facultad', 'docentes_no_evaluados_ibfk_2')->references('id_facultad')->on('facultad');
            $table->foreign('id_coordinacion', 'docentes_no_evaluados_ibfk_3')->references('id_coordinacion')->on('coordinacion');
            $table->foreign('id_programa', 'docentes_no_evaluados_ibfk_4')->references('id_programa')->on('programas');
            $table->foreign('id_curso', 'docentes_no_evaluados_ibfk_5')->references('id_curso')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docentes_no_evaluados');
    }
}
