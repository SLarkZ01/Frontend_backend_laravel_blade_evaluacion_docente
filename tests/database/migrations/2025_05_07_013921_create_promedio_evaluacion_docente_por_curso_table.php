<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromedioEvaluacionDocentePorCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promedio_evaluacion_docente_por_curso', function (Blueprint $table) {
            $table->integer('id_promedio')->primary();
            $table->integer('id_curso')->nullable();
            $table->integer('id_docente')->nullable();
            $table->decimal('promedio_ev_docente', 3, 2)->nullable();
            $table->decimal('promedio_notas_curso', 3, 2)->nullable();
            
            $table->foreign('id_curso', 'promedio_evaluacion_docente_por_curso_ibfk_1')->references('id_curso')->on('cursos');
            $table->foreign('id_docente', 'promedio_evaluacion_docente_por_curso_ibfk_2')->references('id_docente')->on('docente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promedio_evaluacion_docente_por_curso');
    }
}
