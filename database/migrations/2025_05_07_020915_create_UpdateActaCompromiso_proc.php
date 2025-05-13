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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateActaCompromiso`(IN `p_id` INT, IN `p_descripcion` TEXT, IN `p_fecha` DATE)
BEGIN
    UPDATE acta_compromiso
    SET retroalimentacion = p_descripcion,
        fecha_generacion = p_fecha
    WHERE id_acta = p_id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateActaCompromiso");
    }
};
