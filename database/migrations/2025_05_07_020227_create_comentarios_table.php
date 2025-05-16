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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.comentarios\' doesn\'t exist in engine');
            $table->integer('id_comentario');
            $table->string('tipo', 50)->nullable();
            $table->integer('id_docente')->nullable();
            $table->integer('id_programa')->nullable();
            $table->integer('id_coordinacion')->nullable();
            $table->text('comentario1')->nullable();
            $table->text('comentario2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
