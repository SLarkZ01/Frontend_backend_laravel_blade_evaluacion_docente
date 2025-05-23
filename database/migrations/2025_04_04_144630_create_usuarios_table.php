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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // Clave primaria
            $table->integer('id_rol'); // Asegurar que sea el mismo tipo
            $table->boolean('activo')->default(true);
            $table->string('nombre', 255);
            $table->string('correo', 255)->unique();
            $table->string('contrasena', 255);
            $table->timestamps();

            // Clave foránea correctamente definida
            $table->foreign('id_rol')->references('id_rol')->on('rol')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
