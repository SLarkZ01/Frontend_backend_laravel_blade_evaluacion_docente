<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->integer('id_comentario')->primary();
            $table->string('tipo', 50)->nullable();
            $table->integer('id_docente')->nullable();
            $table->integer('id_programa')->nullable();
            $table->integer('id_coordinacion')->nullable();
            $table->text('comentario1')->nullable();
            $table->text('comentario2')->nullable();
            
            $table->foreign('id_docente', 'comentarios_ibfk_1')->references('id_docente')->on('docente');
            $table->foreign('id_programa', 'comentarios_ibfk_2')->references('id_programa')->on('programas');
            $table->foreign('id_coordinacion', 'comentarios_ibfk_3')->references('id_coordinacion')->on('coordinacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
