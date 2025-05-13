<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActaCompromisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acta_compromiso', function (Blueprint $table) {
            $table->integer('id_acta')->primary();
            $table->integer('id_docente')->nullable();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->text('retroalimentacion')->nullable();
            $table->date('fecha_generacion')->nullable();
            
            $table->foreign('id_docente', 'acta_compromiso_ibfk_1')->references('id_docente')->on('docente');
            $table->foreign('id_facultad', 'acta_compromiso_ibfk_2')->references('id_facultad')->on('facultad');
            $table->foreign('id_promedio', 'acta_compromiso_ibfk_3')->references('id_promedio')->on('promedio_evaluacion_docente_por_curso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acta_compromiso');
    }
}
