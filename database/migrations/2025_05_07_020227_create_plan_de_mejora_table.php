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
        Schema::create('plan_de_mejora', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.plan_de_mejora\' doesn\'t exist in engine');
            $table->integer('id_plan_mejora');
            $table->integer('id_facultad')->nullable();
            $table->integer('id_curso')->nullable();
            $table->integer('id_docente')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->integer('progreso')->nullable();
            $table->enum('estado', ['Activo', 'Cerrado', 'Pendiente'])->nullable();
            $table->text('retroalimentacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_de_mejora');
    }
};
