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
        Schema::create('notas_plan_mejora', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.notas_plan_mejora\' doesn\'t exist in engine');
            $table->integer('id_notas_plan_mejora');
            $table->integer('id_plan_mejora')->nullable();
            $table->text('nota')->nullable();
            $table->date('fecha')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_plan_mejora');
    }
};
