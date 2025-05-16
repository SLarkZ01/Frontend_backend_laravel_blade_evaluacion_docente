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
        Schema::create('alertas_bajo_desempeno', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.alertas_bajo_desempeno\' doesn\'t exist in engine');
            $table->integer('id_alerta');
            $table->integer('id_facultad')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->integer('id_docente')->nullable();
            $table->integer('id_curso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas_bajo_desempeno');
    }
};
