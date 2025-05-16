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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerEvaluacionesPorCorreo`(IN `correo_usuario` VARCHAR(255))
BEGIN
    SELECT 
        e.id_evaluacion,
        e.id_docente,
        e.id_curso,
        e.id_periodo,
        e.autoevaluacion,
        e.evaluacion_decano,
        e.evaluacion_estudiantes,
        e.promedio_total,
        p.fecha_fin
    FROM Evaluaciones e
    INNER JOIN Docente d ON e.id_docente = d.id_docente
    INNER JOIN Usuarios u ON d.id_usuario = u.id_usuario
    INNER JOIN Periodos_Academicos p ON e.id_periodo = p.id_periodo
    WHERE u.correo = correo_usuario;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerEvaluacionesPorCorreo");
    }
};
