<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasPlanMejoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_plan_mejora', function (Blueprint $table) {
            $table->integer('id_notas_plan_mejora')->primary();
            $table->integer('id_plan_mejora')->nullable();
            $table->text('nota')->nullable();
            $table->date('fecha')->nullable();
            
            $table->foreign('id_plan_mejora', 'notas_plan_mejora_ibfk_1')->references('id_plan_mejora')->on('plan_de_mejora');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas_plan_mejora');
    }
}
