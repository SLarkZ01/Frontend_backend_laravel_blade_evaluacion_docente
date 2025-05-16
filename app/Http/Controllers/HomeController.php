<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //


    public function index()
    { // Llamar al procedimiento almacenado
    { // Llamar al procedimiento almacenado
        $resultado = DB::select('CALL total_docentes()');

        // Ejecutamos el procedimiento almacenado para obtener el total de docentes no evaluados
        $resultadoTotalNoEvaluados = DB::select('CALL totalNoEvaluados()');
        // Ejecutamos el procedimiento almacenado para obtener el total de docentes no evaluados
        $resultadoTotalNoEvaluados = DB::select('CALL totalNoEvaluados()');


        $resultado3 = DB::select('CALL total_estudiantes_no_evaluaron()');
        $resultado4 = DB::select('CALL promedio_global()');
        $promedios = DB::select('CALL ObtenerPromedioPorFacultad()');
        $labels = collect($promedios)->pluck('facultad');
        $notas = collect($promedios)->pluck('promedio_nota');
        $docentes = DB::select('CALL ObtenerDocentesDestacados()');
        $docentesUnicos = collect($docentes)->unique('nombre_docente');
        $busqueda= DB::select('CALL BuscarDocente(?)', ['nombre_docente']);
        $docentesbusqueda = collect($busqueda)->unique('nombre_docente');
    

        $promedios = DB::select('CALL ObtenerPromedioNotasPorFacultad()');
        $alertas = DB::select('CALL ObtenerAlertasCalificacionesCriticas()');

    // Envía los datos a la vista



        // Verifica si hay datos antes de enviarlo
        if (!empty($resultado3)) {
            $totalEstudiantesNoEvaluaron = $resultado3[0]->total_estudiantes_no_evaluaron;  // Ajusta según el nombre de la columna
        } else {
            $totalEstudiantesNoEvaluaron = 0;
        }
        // Verifica si hay datos antes de enviarlo
        if (!empty($resultadoTotalNoEvaluados)) {
            $totalNoEvaluados = $resultadoTotalNoEvaluados[0]->total_no_evaluados;  // Ajusta según el nombre de la columna
        } else {
            $totalNoEvaluados = 0;
        }
        // Verifica si hay datos antes de enviarlo
        if (!empty($resultado3)) {
            $totalEstudiantesNoEvaluaron = $resultado3[0]->total_estudiantes_no_evaluaron;  // Ajusta según el nombre de la columna
        } else {
            $totalEstudiantesNoEvaluaron = 0;
        }
        // Verifica si hay datos antes de enviarlo
        if (!empty($resultadoTotalNoEvaluados)) {
            $totalNoEvaluados = $resultadoTotalNoEvaluados[0]->total_no_evaluados;  // Ajusta según el nombre de la columna
        } else {
            $totalNoEvaluados = 0;
        }

        // Verifica si hay datos antes de enviarlo
        if (!empty($resultado)) {
            $total_docentes = $resultado[0]->total_docentes;  // Ajusta según el nombre de la columna
        } else {
            $total_docentes = 0;
        }

        // Verifica si hay datos antes de enviarlo
        if (!empty($resultado4)) {
            $promedio_global_p = $resultado4[0]->promedio_global;  // Ajusta según el nombre de la columna
        } else {
            $promedio_global_p = 0;
        }
        // Pasa la variable a la vista
        return view('Decano.index', compact('total_docentes', 'totalNoEvaluados', 'totalEstudiantesNoEvaluaron', 'promedio_global_p', 'promedios', 'labels', 'notas', 'docentes', 'docentesUnicos','promedios','alertas'));
    }
    //total docentes no evaluados

    //total docentes no evaluados



}
}
