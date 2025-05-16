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
        Schema::create('programas', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.programas\' doesn\'t exist in engine');
            $table->integer('id_programa');
            $table->integer('id_docente')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('id_facultad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
