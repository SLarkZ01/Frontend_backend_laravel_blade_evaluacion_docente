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
        Schema::create('proceso_sancion', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.proceso_sancion\' doesn\'t exist in engine');
            $table->integer('id_proceso');
            $table->integer('id_docente')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->enum('sancion', ['Leve', 'Grave', 'Retiro_definitivo'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proceso_sancion');
    }
};
