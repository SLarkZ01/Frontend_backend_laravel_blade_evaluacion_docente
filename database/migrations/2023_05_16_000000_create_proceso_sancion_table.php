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
        Schema::create('proceso_sancion', function (Blueprint $table) {
            $table->id('id_sancion');
            $table->string('numero_resolucion')->unique();
            $table->date('fecha_emision');
            $table->string('nombre_docente');
            $table->string('apellido_docente');
            $table->string('identificacion_docente');
            $table->string('asignatura');
            $table->decimal('calificacion_final', 3, 2);
            $table->string('tipo_sancion');
            $table->text('antecedentes')->nullable();
            $table->text('fundamentos')->nullable();
            $table->text('resolucion')->nullable();
            $table->string('firma_path')->nullable();
            $table->boolean('enviado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proceso_sancion');
    }
};