<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesNoEvaluaronTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes_no_evaluaron', function (Blueprint $table) {
            $table->integer('id_estudiante')->primary();
            $table->integer('id_programa')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_curso')->nullable();
            
            $table->foreign('id_estudiante', 'estudiantes_no_evaluaron_ibfk_1')->references('id_estudiante')->on('estudiantes');
            $table->foreign('id_programa', 'estudiantes_no_evaluaron_ibfk_2')->references('id_programa')->on('programas');
            $table->foreign('id_facultad', 'estudiantes_no_evaluaron_ibfk_3')->references('id_facultad')->on('facultad');
            $table->foreign('id_curso', 'estudiantes_no_evaluaron_ibfk_4')->references('id_curso')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes_no_evaluaron');
    }
}
