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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `promedio_por_curso`()
BEGIN
    SELECT 
        c.id_curso,
        ROUND(AVG(e.promedio_total), 2) AS promedio_curso
    FROM 
        cursos c  -- Asumí que tienes una tabla de \"cursos\", cámbiala si es otro nombre
    JOIN 
        evaluaciones e ON c.id_curso = e.id_curso
    GROUP BY 
        c.id_curso;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS promedio_por_curso");
    }
};
