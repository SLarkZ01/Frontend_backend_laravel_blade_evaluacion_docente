<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Services\ActaCompromisoService;
use App\Services\ProcesoSancionService;

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
        $docentesbusqueda = DB::select('CALL BuscarDocente()');
        $actaService = new ActaCompromisoService();
        $response = $actaService->getAll();
        
        $actas = $response['data'] ?? [];
        return view('decano.acta_compromiso', compact('docentesbusqueda', 'actas'));
    }
    
    /**
     * Guarda una nueva acta de compromiso
     */
    public function guardar_acta(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_acta' => 'required|string|unique:acta_compromiso,numero_acta',
            'fecha_generacion' => 'required|date',
            'nombre_docente' => 'required|string|max:255',
            'apellido_docente' => 'required|string|max:255',
            'identificacion_docente' => 'required|string|max:20',
            'asignatura' => 'required|string|max:255',
            'calificacion_final' => 'required|numeric|between:0,5.00',
            'retroalimentacion' => 'required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $firmaPath = null;
        if ($request->hasFile('firma')) {
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $firmaPath = 'firmas/' . $firmaName;
        }

        $data = [
            'numero_acta' => $request->numero_acta,
            'fecha_generacion' => $request->fecha_generacion,
            'nombre_docente' => $request->nombre_docente,
            'apellido_docente' => $request->apellido_docente,
            'identificacion_docente' => $request->identificacion_docente,
            'asignatura' => $request->asignatura,
            'calificacion_final' => $request->calificacion_final,
            'retroalimentacion' => $request->retroalimentacion,
            'firma_path' => $firmaPath,
            'enviado' => false
        ];
        
        $actaService = new ActaCompromisoService();
        $response = $actaService->create($data);
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->back()
                ->withErrors(['error' => $response['message'] ?? 'Error al crear acta de compromiso'])
                ->withInput();
        }

        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso creada exitosamente');
    }

    /**
     * Muestra el formulario para editar un acta
     */
    public function editar_acta($id)
    {
        $actaService = new ActaCompromisoService();
        $response = $actaService->getById($id);
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('decano.acta_compromiso')
                ->withErrors(['error' => $response['message'] ?? 'Acta de compromiso no encontrada']);
        }
        
        $acta = $response['data'] ?? null;
        $docentesbusqueda = DB::select('CALL BuscarDocente()');
        return view('decano.editar_acta', compact('acta', 'docentesbusqueda'));
    }

    /**
     * Actualiza un acta existente
     */
    public function actualizar_acta(Request $request, $id)
    {
        $actaService = new ActaCompromisoService();
        $actaResponse = $actaService->getById($id);
        
        if (!isset($actaResponse['success']) || !$actaResponse['success']) {
            return redirect()->route('decano.acta_compromiso')
                ->withErrors(['error' => $actaResponse['message'] ?? 'Acta de compromiso no encontrada']);
        }
        
        $acta = $actaResponse['data'] ?? null;
        
        $validator = Validator::make($request->all(), [
            'numero_acta' => 'required|string|unique:acta_compromiso,numero_acta,' . $id,
            'fecha_generacion' => 'required|date',
            'nombre_docente' => 'required|string|max:255',
            'apellido_docente' => 'required|string|max:255',
            'identificacion_docente' => 'required|string|max:20',
            'asignatura' => 'required|string|max:255',
            'calificacion_final' => 'required|numeric|between:0,5.00',
            'retroalimentacion' => 'required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $firmaPath = $acta['firma_path'] ?? null;
        if ($request->hasFile('firma')) {
            // Eliminar firma anterior si existe
            if ($firmaPath) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $firmaPath);
            }
            
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $firmaPath = 'firmas/' . $firmaName;
        }

        $data = [
            'numero_acta' => $request->numero_acta,
            'fecha_generacion' => $request->fecha_generacion,
            'nombre_docente' => $request->nombre_docente,
            'apellido_docente' => $request->apellido_docente,
            'identificacion_docente' => $request->identificacion_docente,
            'asignatura' => $request->asignatura,
            'calificacion_final' => $request->calificacion_final,
            'retroalimentacion' => $request->retroalimentacion,
            'firma_path' => $firmaPath
        ];
        
        $response = $actaService->update($id, $data);
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->back()
                ->withErrors(['error' => $response['message'] ?? 'Error al actualizar acta de compromiso'])
                ->withInput();
        }

        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso actualizada exitosamente');
    }

    /**
     * Elimina un acta
     */
    public function eliminar_acta($id_acta)
    {
        $actaService = new ActaCompromisoService();
        $actaResponse = $actaService->getById($id_acta);
        
        if (isset($actaResponse['success']) && $actaResponse['success']) {
            $acta = $actaResponse['data'] ?? null;
            
            // Eliminar firma si existe
            if (isset($acta['firma_path']) && $acta['firma_path']) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $acta['firma_path']);
            }
        }

        $response = $actaService->delete($id_acta);
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('decano.acta_compromiso')
                ->withErrors(['error' => $response['message'] ?? 'Error al eliminar acta de compromiso']);
        }

        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso eliminada exitosamente');
    }

    /**
     * Marca un acta como enviada
     */
    public function enviar_acta($id_acta)
    {
        $actaService = new ActaCompromisoService();
        $response = $actaService->markAsSent($id_acta);
        
        if (!isset($response['success']) || !$response['success']) {
            return redirect()->route('decano.acta_compromiso')
                ->withErrors(['error' => $response['message'] ?? 'Error al enviar acta de compromiso']);
        }

        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso enviada exitosamente');
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

    //proceso sancion retiro

    public function psr()
    {
        // Obtener todos los procesos de sanción usando el servicio
        $procesoService = new ProcesoSancionService();
        $procesosResponse = $procesoService->getAll();
        $procesos = $procesosResponse;
        
        // Obtener docentes con calificaciones bajas para sugerir sanciones
        $docentesBajoDesempeno = DB::select('CALL ObtenerDocentesCalificacionesBajas(?)', [3.00]);
        
        return view('decano.proceso_sancion_retiro', compact('procesos', 'docentesBajoDesempeno'));
    }
    
    /**
     * Busca procesos de sanción por nombre de docente
     */
    public function buscarProcesoSancion(Request $request)
    {
        $nombre = $request->input('nombre');
        $procesoService = new ProcesoSancionService();
        $response = $procesoService->searchByDocente($nombre);
        return response()->json($response);
    }
    
    /**
     * Filtra procesos de sanción por tipo
     */
    public function filtrarProcesoSancionPorTipo(Request $request)
    {
        $tipo = $request->input('tipo_sancion');
        $procesoService = new ProcesoSancionService();
        $response = $procesoService->filterByTipo($tipo);
        return response()->json($response);
    }
    
    /**
     * Filtra procesos de sanción por rango de calificación
     */
    public function filtrarProcesoSancionPorCalificacion(Request $request)
    {
        $min = $request->input('calificacion_min');
        $max = $request->input('calificacion_max');
        $procesoService = new ProcesoSancionService();
        $response = $procesoService->filterByCalificacion($min, $max);
        return response()->json($response);
    }
    
    /**
     * Guarda un nuevo proceso de sanción
     */
    public function guardarProcesoSancion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_resolucion' => 'required|string|unique:proceso_sancion,numero_resolucion',
            'fecha_emision' => 'required|date',
            'nombre_docente' => 'required|string|max:255',
            'apellido_docente' => 'required|string|max:255',
            'identificacion_docente' => 'required|string|max:20',
            'asignatura' => 'required|string|max:255',
            'calificacion_final' => 'required|numeric|between:0,5.00',
            'tipo_sancion' => 'required|string',
            'antecedentes' => 'required|string',
            'fundamentos' => 'required|string',
            'resolucion' => 'required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $firmaPath = null;
        if ($request->hasFile('firma')) {
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $firmaPath = 'firmas/' . $firmaName;
        }

        $data = [
            'numero_resolucion' => $request->numero_resolucion,
            'fecha_emision' => $request->fecha_emision,
            'nombre_docente' => $request->nombre_docente,
            'apellido_docente' => $request->apellido_docente,
            'identificacion_docente' => $request->identificacion_docente,
            'asignatura' => $request->asignatura,
            'calificacion_final' => $request->calificacion_final,
            'tipo_sancion' => $request->tipo_sancion,
            'antecedentes' => $request->antecedentes,
            'fundamentos' => $request->fundamentos,
            'resolucion' => $request->resolucion,
            'firma_path' => $firmaPath
        ];
        
        $procesoService = new ProcesoSancionService();
        $response = $procesoService->create($data);

        return response()->json($response);
    }
    
    /**
     * Obtiene un proceso de sanción por ID
     */
    public function obtenerProcesoSancion($id)
    {
        $procesoService = new ProcesoSancionService();
        $response = $procesoService->getById($id);
        
        if (!isset($response['success']) || !$response['success']) {
            return response()->json(['error' => $response['message'] ?? 'Proceso de sanción no encontrado'], 404);
        }
        
        return response()->json($response);
    }
    
    /**
     * Actualiza un proceso de sanción
     */
    public function actualizarProcesoSancion(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'numero_resolucion' => 'required|string|unique:proceso_sancion,numero_resolucion,' . $id . ',id_sancion',
            'fecha_emision' => 'required|date',
            'nombre_docente' => 'required|string|max:255',
            'apellido_docente' => 'required|string|max:255',
            'identificacion_docente' => 'required|string|max:20',
            'asignatura' => 'required|string|max:255',
            'calificacion_final' => 'required|numeric|between:0,5.00',
            'tipo_sancion' => 'required|string',
            'antecedentes' => 'required|string',
        ]);

        // Verificar si el proceso existe usando el servicio
        $procesoService = new ProcesoSancionService();
        $procesoResponse = $procesoService->getById($id);
        
        if (!isset($procesoResponse['success']) || !$procesoResponse['success']) {
            return response()->json(['error' => 'Proceso de sanción no encontrado'], 404);
        }
        
        $proceso = $procesoResponse['data'] ?? null;
        $firmaPath = $proceso['firma_path'] ?? null;
        
        if ($request->hasFile('firma')) {
            // Eliminar firma anterior si existe
            if ($firmaPath) {
                Storage::delete('public/' . $firmaPath);
            }
            
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $firmaPath = 'firmas/' . $firmaName;
        }

        $data = [
            'numero_resolucion' => $request->numero_resolucion,
            'fecha_emision' => $request->fecha_emision,
            'nombre_docente' => $request->nombre_docente,
            'apellido_docente' => $request->apellido_docente,
            'identificacion_docente' => $request->identificacion_docente,
            'asignatura' => $request->asignatura,
            'calificacion_final' => $request->calificacion_final,
            'tipo_sancion' => $request->tipo_sancion,
            'antecedentes' => $request->antecedentes,
            'fundamentos' => $request->fundamentos,
            'resolucion' => $request->resolucion,
            'firma_path' => $firmaPath
        ];
        
        $response = $procesoService->update($id, $data);

        return response()->json($response);
    }
    
    /**
     * Elimina un proceso de sanción
     */
    public function eliminarProcesoSancion($id)
    {
        $procesoService = new ProcesoSancionService();
        $procesoResponse = $procesoService->getById($id);
        
        if (isset($procesoResponse['success']) && $procesoResponse['success']) {
            $proceso = $procesoResponse['data'] ?? null;
            
            // Eliminar firma si existe
            if (isset($proceso['firma_path']) && $proceso['firma_path']) {
                Storage::delete('public/' . $proceso['firma_path']);
            }
        } else {
            return response()->json(['error' => 'Proceso de sanción no encontrado'], 404);
        }
        
        $response = $procesoService->delete($id);
        
        return response()->json($response);
    }
    
    /**
     * Marca un proceso de sanción como enviado
     */
    public function enviarProcesoSancion($id)
    {
        $procesoService = new ProcesoSancionService();
        $response = $procesoService->markAsSent($id);
        
        if (!isset($response['success']) || !$response['success']) {
            return response()->json(['error' => $response['message'] ?? 'Error al marcar proceso como enviado'], 404);
        }
        
        return response()->json($response);
    }

    
    /**
     * Marca un proceso de sanción como enviado
     */
    //seguimiento plan de mejora
public function spm()
    {
        return view('decano.seguimiento_plan_mejora');
    }

    /**
     * Muestra el formulario para editar un acta de compromiso
     */
    public function editarActa($id_acta)
    {
        // Obtener el acta de compromiso por ID usando el procedimiento almacenado
        $actas = DB::select('CALL GetActaCompromisoById(?)', [$id_acta]);
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
    public function ActualizarActa(Request $request, $id)
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