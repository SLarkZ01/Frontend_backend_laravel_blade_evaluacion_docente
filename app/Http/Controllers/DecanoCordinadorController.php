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
public function mostrarGrafica()
    {
        // Ejecuta el procedimiento almacenado
        $promedios = DB::select('CALL ObtenerPromedioNotasPorFacultad()');

        // Extrae las etiquetas (facultades) y los datos (promedios)
        return view('decano.mostrarGrafica',['evaluaciones' => $promedios]);
    }

    public function mostrarAlertas()
    {
        $alertas = DB::select('CALL ObtenerAlertasCalificacionesCriticas()');
    
        return view('tu_vista', compact('alertas'));
    }
    
    
//docentes destacados
    public function acta_compromiso()
    {
        // Obtener la lista de docentes para la búsqueda
        $docentesbusqueda = DB::select('CALL BuscarDocente()');
        
        // Obtener las actas de compromiso existentes usando el procedimiento almacenado
        $actas = DB::select('CALL GetActasCompromiso()');
            
        return view('decano.acta_compromiso', compact('docentesbusqueda', 'actas'));
        
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

    /**
     * Muestra el formulario para editar un acta de compromiso
     */
    public function editarActa($id)
    {
        // Obtener el acta de compromiso por ID usando el procedimiento almacenado
        $actas = DB::select('CALL GetActaCompromisoById(?)', [$id]);
        $acta = $actas[0] ?? null;
        
        if (!$acta) {
            return redirect()->route('decano.acta_compromiso')
                ->with('error', 'Acta de compromiso no encontrada');
        }
        
        // La información del docente ya viene incluida en el resultado del procedimiento almacenado
        $docente = (object)[
            'id_docente' => $acta->id_docente,
            'nombre' => $acta->nombre_docente,
        ];
            
        return view('decano.editar_acta', compact('acta', 'docente'));
    }

    /**
     * Actualiza un acta de compromiso en la base de datos
     */
    public function actualizarActa(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'numero_acta' => 'required|string',
            'fecha_generacion' => 'required|date',
            'retroalimentacion' => 'required|string'
        ]);
        
        // Actualizar el acta en la base de datos usando el procedimiento almacenado
        $result = DB::select('CALL UpdateActaCompromiso(?, ?, ?)', [
            $id,
            $request->retroalimentacion,
            $request->fecha_generacion
        ]);
        
        // Si se cargó una nueva firma, procesarla y actualizar el campo de firma por separado
        if ($request->hasFile('firma')) {
            $firma = $request->file('firma');
            $nombreFirma = time() . '_' . $firma->getClientOriginalName();
            $firma->move(public_path('firmas'), $nombreFirma);
            
            // Actualizar solo el campo de firma
            DB::table('acta_compromiso')
                ->where('id_acta', $id)
                ->update(['firma' => '/firmas/' . $nombreFirma]);
        } elseif ($request->has('firma_actual')) {
            // Actualizar solo el campo de firma con el valor actual
            DB::table('acta_compromiso')
                ->where('id_acta', $id)
                ->update(['firma' => $request->firma_actual]);
        }
        
        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso actualizada correctamente');
    }
}
