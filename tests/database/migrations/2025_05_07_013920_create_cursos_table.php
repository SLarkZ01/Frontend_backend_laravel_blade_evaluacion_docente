<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->integer('id_curso')->primary();
            $table->string('codigo', 50)->nullable()->unique('codigo');
            $table->string('nombre', 50)->nullable();
            $table->integer('id_programa')->nullable();
            $table->integer('id_docente')->nullable();
            
            $table->foreign('id_programa', 'cursos_ibfk_1')->references('id_programa')->on('programas');
            $table->foreign('id_docente', 'cursos_ibfk_2')->references('id_docente')->on('docente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
