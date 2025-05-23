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
        Schema::create('acta_compromiso', function (Blueprint $table) {
            $table->id();
    $table->string('numero_acta')->unique();
    $table->date('fecha_generacion');
    $table->string('nombre_docente');
    $table->string('apellido_docente');
    $table->string('identificacion_docente', 20);
    $table->string('asignatura');
    $table->decimal('calificacion_final', 3, 2); // por ejemplo: 4.75
    $table->text('retroalimentacion');
    $table->string('firma')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acta_compromiso');
    }
};
