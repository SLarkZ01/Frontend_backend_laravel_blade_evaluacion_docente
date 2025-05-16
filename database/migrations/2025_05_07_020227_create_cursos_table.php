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
        Schema::create('cursos', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.cursos\' doesn\'t exist in engine');
            $table->integer('id_curso');
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 50)->nullable();
            $table->integer('id_programa')->nullable();
            $table->integer('id_docente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
