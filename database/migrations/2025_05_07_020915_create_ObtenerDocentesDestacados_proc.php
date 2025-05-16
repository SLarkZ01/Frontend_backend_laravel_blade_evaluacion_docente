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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDocentesDestacados`()
BEGIN
    -- Seleccionamos los docentes más destacados, ordenados por el promedio de calificación
    SELECT 
        d.nombre AS docente,      -- Nombre del docente
        c.nombre AS curso,        -- Nombre del curso
        e.promedio_total AS calificacion   -- Promedio total
    FROM 
        Evaluaciones e
    INNER JOIN 
        Docente d ON d.id_docente = e.id_docente   -- Hacemos JOIN con la tabla Docente
    INNER JOIN 
        Cursos c ON c.id_curso = e.id_curso       -- Hacemos JOIN con la tabla Cursos
    WHERE 
        e.promedio_total > 4.0      -- Filtramos los docentes con promedio mayor a 4.0
    ORDER BY 
        e.promedio_total DESC       -- Ordenamos por el promedio de calificación en orden descendente
    LIMIT 5;   -- Limitar a los 5 primeros docentes destacados
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerDocentesDestacados");
    }
};
