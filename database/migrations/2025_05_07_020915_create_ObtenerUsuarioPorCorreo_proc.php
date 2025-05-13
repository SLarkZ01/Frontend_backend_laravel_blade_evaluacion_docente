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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerUsuarioPorCorreo`(IN `correo_usuario` VARCHAR(255))
BEGIN
    SELECT * 
    FROM usuarios
    WHERE correo = correo_usuario
    LIMIT 1;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerUsuarioPorCorreo");
    }
};
