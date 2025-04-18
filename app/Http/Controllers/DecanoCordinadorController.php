<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecanoCordinadorController extends Controller
{
    //
    //total_docentes
   
    
        public function total_docentes()
    {
        $docentes = DB::select('CALL total_docentes()');
        return view('decano.total_docentes', compact('docentes'));
    }
    //total docentes no evaluados
    public function totalNoEvaluados()
    {
        // Ejecutamos el procedimiento almacenado para obtener el total de docentes no evaluados
        $totalNoEvaluados = DB::select('CALL totalNoEvaluados()');
        $totalNoEvaluados = $totalNoEvaluados[0] ?? null;
        // Pasamos la variable $totalNoEvaluados a la vista
        return view('decano.totalNoEvaluados', compact('totalNoEvaluados'));
    }
    public function totalEstudiantesNoEvaluaron()
    {
        // Ejecutamos el procedimiento almacenado para obtener el total de estudiantes no evaluados
        $totalEstudiantesNoEvaluaron = DB::select('CALL ObtenerTotalEstudiantesNoEvaluaron()');
        
        // Pasamos la variable $totalEstudiantesNoEvaluaron a la vista
        return view('decano.totalEstudiantesNoEvaluaron', compact('totalEstudiantesNoEvaluaron'));
    }
    //promedio por facultad
    public function promedio_global()
    {
        // Ejecutamos el procedimiento almacenado para obtener el promedio por facultad
        $promedio_global = DB::select('CALL promedio_global()');
        // Pasamos la variable $promedio_global a la vista
        return view('decano.promedio_global', compact('promedio_global'));
    }
    //promedio por facultad
    
    public function obtenerPromedioPorFacultad() {
        // Ejecutamos el procedimiento almacenado
    $datos = collect(DB::select('CALL ObtenerPromedioPorFacultad()'));
// Asegúrate de que devuelva: facultad, promedio_nota
    $labels = $datos->pluck('facultad');
    $notas = $datos->pluck('promedio_nota');

return view('graficas.facultades', compact('labels', 'promedio_nota'));
    
}
 
public function docentesDestacados()
{
    // Ejecutar el procedimiento almacenado
    $docentes = DB::select('CALL ObtenerDocentesDestacados()');

    // Verificar los datos obtenidos
    dd($docentes);  // Verifica los datos obtenidos de la base de datos

    // Filtrar los duplicados basados en el nombre del docente
    $docentesUnicos = collect($docentes)->unique('docente');

    // Verificar los datos después de filtrar duplicados
    dd($docentesUnicos);  // Verifica los datos después de filtrar duplicados

    // Pasar los docentes únicos a la vista
    return view('decano.docentesDestacados', compact('docentesUnicos'));
}

//ocentes destacados
    public function acta_compromiso()
    {
        

    $docentesbusqueda = DB::select('CALL BuscarDocente()');
    return view('decano.acta_compromiso', compact('docentesbusqueda'));

    
    }
    
//alertas bajo desempeño
    public function abd()
    {
        return view('decano.alertas_bajo_desempeno');
    }

    //modales seguimiento
    public function seguimiento()
    {
        return view('decano.modales_seguimiento');
    }

    //proseso sancion retiro

    public function psr()
    {
        return view('decano.proceso_sancion_retiro');
    }

    //seguimiento plan de mejora
    public function spm()
    {
        return view('decano.seguimiento_plan_mejora');
    }
}
