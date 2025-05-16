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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerAlertasCriticas`()
BEGIN
    SELECT 
        d.nombre AS docente,
        f.nombre AS facultad,
        c.nombre AS curso,
        e.promedio_total AS calificacion
    FROM 
        Evaluaciones e
    INNER JOIN 
        Docente d ON d.id_docente = e.id_docente
    INNER JOIN 
        Cursos c ON c.id_curso = e.id_curso
    INNER JOIN 
        Programas p ON p.id_docente = d.id_docente
    INNER JOIN 
        Facultad f ON f.id_facultad = p.id_facultad
    WHERE 
        e.promedio_total < 3.0
    ORDER BY 
        f.nombre, e.promedio_total ASC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerAlertasCriticas");
    }
};
