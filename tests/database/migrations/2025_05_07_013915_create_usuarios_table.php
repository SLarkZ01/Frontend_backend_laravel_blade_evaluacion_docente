<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id_usuario')->primary();
            $table->integer('id_rol')->nullable();
            $table->tinyInteger('activo')->nullable();
            $table->string('nombre');
            $table->string('correo')->unique('correo');
            $table->string('contrasena');
            $table->enum('tipo_usuario', ['docente', 'coordinador', 'administrador']);
            
            $table->foreign('id_rol', 'usuarios_ibfk_1')->references('id_rol')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
