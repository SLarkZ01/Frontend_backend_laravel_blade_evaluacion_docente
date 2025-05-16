<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docente', function (Blueprint $table) {
            $table->integer('id_docente')->primary();
            $table->integer('id_usuario')->nullable();
            $table->integer('cod_docente')->nullable();
            $table->string('nombre', 50)->nullable();
            $table->string('correo', 100)->nullable();
            
            $table->foreign('id_usuario', 'docente_ibfk_1')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docente');
    }
}
