<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facultad', function (Blueprint $table) {
            $table->integer('id_facultad')->primary();
            $table->integer('id_coordinacion')->nullable();
            $table->string('nombre', 50)->nullable();
            
            $table->foreign('id_coordinacion', 'facultad_ibfk_1')->references('id_coordinacion')->on('coordinacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facultad');
    }
}
