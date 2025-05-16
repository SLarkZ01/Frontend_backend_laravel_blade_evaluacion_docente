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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `GetActaCompromisoById`(IN `p_id_acta` INT)
BEGIN
    SELECT 
        AC.fecha_generacion,
        AC.retroalimentacion,
        AC.id_acta ,
        AC.id_acta as numero_acta,
        AC.id_promedio,
        E.promedio_total as calificacion_final,
        U.nombre as nombre_docente,
        F.nombre as facultad
    FROM Acta_Compromiso AC
    INNER JOIN Docente D ON AC.id_docente = D.id_docente
    INNER JOIN Usuarios U ON D.id_usuario = U.id_usuario
    INNER JOIN Evaluaciones E ON D.id_docente = E.id_docente
    INNER JOIN Facultad F ON AC.id_facultad = F.id_facultad
    WHERE AC.id_acta = p_id_acta;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetActaCompromisoById");
    }
};
