<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->integer('id_programa')->primary();
            $table->integer('id_docente')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('id_facultad')->nullable();
            
            $table->foreign('id_facultad', 'programas_ibfk_1')->references('id_facultad')->on('facultad');
            $table->foreign('id_docente', 'programas_ibfk_2')->references('id_docente')->on('docente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programas');
    }
}
