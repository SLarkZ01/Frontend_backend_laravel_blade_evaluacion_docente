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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarDocente`(IN `terminoBusqueda` VARCHAR(100))
BEGIN
    SELECT 
        d.id_docente,
        d.nombre AS nombre_docente,
        d.apellido AS apellido_docente,
        d.identificacion AS identificacion_docente,
        c.nombre AS asignatura,
        e.promedio_total AS calificacion_final,
        d.cod_docente,
        d.correo
    FROM Docente d
    LEFT JOIN Evaluaciones e ON d.id_docente = e.id_docente
    LEFT JOIN Cursos c ON c.id_curso = e.id_curso
    WHERE (terminoBusqueda IS NULL OR terminoBusqueda = '' OR 
           d.nombre LIKE CONCAT('%', terminoBusqueda, '%') OR
           d.apellido LIKE CONCAT('%', terminoBusqueda, '%') OR
           d.cod_docente LIKE CONCAT('%', terminoBusqueda, '%'))
    AND (e.promedio_total < 4.0 OR e.promedio_total IS NULL)
    ORDER BY d.nombre, d.apellido;
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
