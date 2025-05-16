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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerPromedioNotasPorFacultad`()
SELECT 
    f.nombre AS facultad,
    ROUND(AVG(ev.promedio_total), 2) AS promedio
FROM 
    Evaluaciones ev
JOIN 
    Docente d ON ev.id_docente = d.id_docente
JOIN 
    Programas p ON d.id_docente = p.id_docente
JOIN 
    Facultad f ON p.id_facultad = f.id_facultad
GROUP BY 
    f.nombre");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerPromedioNotasPorFacultad");
    }
};
