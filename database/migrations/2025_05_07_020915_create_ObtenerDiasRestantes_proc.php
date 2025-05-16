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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDiasRestantes`(IN idPeriodo INT)
BEGIN
    DECLARE diasRestantes INT;
    DECLARE fechaFin DATE;

    -- Obtener la fecha de finalización del periodo académico
    SELECT fecha_fin INTO fechaFin
    FROM Periodos_Academicos
    WHERE id_periodo = idPeriodo;

    -- Calcular los días restantes
    SET diasRestantes = DATEDIFF(fechaFin, CURDATE());

    -- Devolver los días restantes
    SELECT diasRestantes AS DiasRestantes;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerDiasRestantes");
    }
};
