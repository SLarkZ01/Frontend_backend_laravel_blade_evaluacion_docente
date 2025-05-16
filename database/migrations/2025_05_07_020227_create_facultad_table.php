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
        Schema::create('facultad', function (Blueprint $table) {
            $table->comment('Table \'evaluacion_docentes.facultad\' doesn\'t exist in engine');
            $table->integer('id_facultad');
            $table->integer('id_coordinacion')->nullable();
            $table->string('nombre', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facultad');
    }
};
