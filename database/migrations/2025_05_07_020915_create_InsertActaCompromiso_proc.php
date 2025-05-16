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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertActaCompromiso`(IN `p_docente_id` INT, IN `p_descripcion` TEXT, IN `p_fecha` DATE)
BEGIN
    INSERT INTO acta_compromiso (id_docente,retroalimentacion,fecha_generacion)
    VALUES (p_docente_id, p_descripcion, p_fecha);
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertActaCompromiso");
    }
};
