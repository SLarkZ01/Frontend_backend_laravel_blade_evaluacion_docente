<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->integer('id_estudiante')->primary();
            $table->string('nombre', 50)->nullable();
            $table->string('correo', 50)->nullable();
            $table->integer('semestre')->nullable();
            $table->integer('id_programa')->nullable();
            
            $table->foreign('id_programa', 'estudiantes_ibfk_1')->references('id_programa')->on('programas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
}
