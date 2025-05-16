<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarDocente`()
BEGIN
    SELECT 
        d.id_docente,
        d.nombre,
        d.cod_docente,
        d.correo,
        e.promedio_total AS calificacion,
        c.nombre AS curso
    FROM Docente d
    LEFT JOIN Evaluaciones e ON d.id_docente = e.id_docente
    LEFT JOIN Cursos c ON c.id_curso = e.id_curso;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS BuscarDocente");
    }
};
