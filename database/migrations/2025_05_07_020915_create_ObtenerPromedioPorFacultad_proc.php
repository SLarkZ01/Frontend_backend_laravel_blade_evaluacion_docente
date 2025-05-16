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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerPromedioPorFacultad`()
BEGIN
    SELECT 
        f.nombre AS facultad,
        ROUND(AVG(p.promedio_ev_docente),2) AS promedio_calificacion
    FROM Promedio_Evaluacion_Docente_Por_Curso p
    INNER JOIN Cursos c ON p.id_curso = c.id_curso
    INNER JOIN Programas pr ON c.id_programa = pr.id_programa
    INNER JOIN Facultad f ON pr.id_facultad = f.id_facultad
    GROUP BY f.nombre
    ORDER BY promedio_calificacion DESC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerPromedioPorFacultad");
    }
};
