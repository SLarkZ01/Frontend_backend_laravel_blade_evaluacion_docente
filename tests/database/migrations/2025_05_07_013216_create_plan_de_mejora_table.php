<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanDeMejoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_de_mejora', function (Blueprint $table) {
            $table->integer('id_plan_mejora')->primary();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_curso')->nullable();
            $table->integer('id_docente')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->integer('progreso')->nullable();
            $table->enum('estado', ['Activo', 'Cerrado', 'Pendiente'])->nullable();
            $table->text('retroalimentacion')->nullable();
            
            $table->foreign('id_facultad', 'plan_de_mejora_ibfk_1')->references('id_facultad')->on('facultad');
            $table->foreign('id_curso', 'plan_de_mejora_ibfk_2')->references('id_curso')->on('cursos');
            $table->foreign('id_docente', 'plan_de_mejora_ibfk_3')->references('id_docente')->on('docente');
            $table->foreign('id_promedio', 'plan_de_mejora_ibfk_4')->references('id_promedio')->on('promedio_evaluacion_docente_por_curso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_de_mejora');
    }
}
