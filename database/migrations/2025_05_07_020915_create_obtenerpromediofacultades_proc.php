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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `obtenerpromediofacultades`()
BEGIN
    SELECT f.nombre AS facultad, ROUND(AVG(e.calificacion), 2) AS promedio
    FROM facultades f
    JOIN evaluaciones e ON e.facultad_id = f.id
    GROUP BY f.id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS obtenerpromediofacultades");
    }
};
