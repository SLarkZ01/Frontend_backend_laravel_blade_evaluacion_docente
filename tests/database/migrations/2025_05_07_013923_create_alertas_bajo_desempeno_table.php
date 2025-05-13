<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertasBajoDesempenoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertas_bajo_desempeno', function (Blueprint $table) {
            $table->integer('id_alerta')->primary();
            $table->integer('id_facultad')->nullable();
            $table->integer('id_promedio')->nullable();
            $table->integer('id_docente')->nullable();
            $table->integer('id_curso')->nullable();
            
            $table->foreign('id_facultad', 'alertas_bajo_desempeno_ibfk_1')->references('id_facultad')->on('facultad');
            $table->foreign('id_promedio', 'alertas_bajo_desempeno_ibfk_2')->references('id_promedio')->on('promedio_evaluacion_docente_por_curso');
            $table->foreign('id_docente', 'alertas_bajo_desempeno_ibfk_3')->references('id_docente')->on('docente');
            $table->foreign('id_curso', 'alertas_bajo_desempeno_ibfk_4')->references('id_curso')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alertas_bajo_desempeno');
    }
}
