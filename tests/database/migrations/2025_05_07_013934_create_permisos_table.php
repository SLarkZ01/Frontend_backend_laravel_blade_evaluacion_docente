<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->integer('id_permiso')->primary();
            $table->integer('id_usuario')->nullable();
            $table->string('nombre', 50)->unique('nombre');
            $table->text('descripcion')->nullable();
            $table->string('modulo_permiso', 50)->nullable();
            
            $table->foreign('id_usuario', 'permisos_ibfk_1')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
