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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `notas_clasificadas`()
BEGIN
    SELECT nombre, promedio_total,
        CASE 
            WHEN promedio_total  BETWEEN 4.5 AND 5.0 THEN 'Excelente'
            WHEN promedio_total  BETWEEN 4.0 AND 4.4 THEN 'Bueno'
            WHEN promedio_total  BETWEEN 3.5 AND 3.9 THEN 'Aceptable'
            WHEN promedio_total  BETWEEN 3.0 AND 3.4 THEN 'Regular'
            WHEN promedio_total < 3.0 THEN 'Deficiente'
            ELSE 'Sin clasificación'
        END
    FROM evaluaciones,cursos;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS notas_clasificadas");
    }
};
