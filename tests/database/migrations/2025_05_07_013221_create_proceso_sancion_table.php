<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoSancionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_sancion', function (Blueprint $table) {
            $table->integer('id_proceso')->primary();
            $table->integer('id_docente')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->enum('sancion', ['Leve', 'Grave', 'Retiro_definitivo'])->nullable();
            
            $table->foreign('id_docente', 'proceso_sancion_ibfk_1')->references('id_docente')->on('docente');
            $table->foreign('id_facultad', 'proceso_sancion_ibfk_2')->references('id_facultad')->on('facultad');
            $table->foreign('id_promedio', 'proceso_sancion_ibfk_3')->references('id_promedio')->on('promedio_evaluacion_docente_por_curso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proceso_sancion');
    }
}
