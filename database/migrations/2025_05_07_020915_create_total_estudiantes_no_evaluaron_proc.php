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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `total_estudiantes_no_evaluaron`()
BEGIN
    SELECT COUNT(*) As total_estudiantes_no_evaluaron
    FROM estudiantes_no_evaluaron;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS total_estudiantes_no_evaluaron");
    }
};
