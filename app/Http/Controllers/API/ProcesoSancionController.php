<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProcesoSancion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProcesoSancionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procesos = DB::select('CALL ObtenerTodosProcesosSancion()');
        return response()->json($procesos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $resultado = DB::select('CALL CrearProcesoSancion(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $request->numero_resolucion,
            $request->fecha_emision,
            $request->nombre_docente,
            $request->apellido_docente,
            $request->identificacion_docente,
            $request->asignatura,
            $request->calificacion_final,
            $request->tipo_sancion,
            $request->antecedentes,
            $request->fundamentos,
            $request->resolucion,
            $firmaPath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proceso de sanción creado exitosamente',
            'id_sancion' => $resultado[0]->id_sancion ?? null
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $procesos = DB::select('CALL ObtenerProcesoSancionPorId(?)', [$id]);
        $proceso = $procesos[0] ?? null;
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de sanción no encontrado'], 404);
        }
        
        return response()->json($proceso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            'fundamentos' => 'required|string',
            'resolucion' => 'required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Verificar si el proceso existe
        $procesos = DB::select('CALL ObtenerProcesoSancionPorId(?)', [$id]);
        $proceso = $procesos[0] ?? null;
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de sanción no encontrado'], 404);
        }

        $firmaPath = null;
        if ($request->hasFile('firma')) {
            // Eliminar firma anterior si existe
            if ($proceso->firma_path) {
                Storage::delete('public/' . $proceso->firma_path);
            }
            
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $firmaPath = 'firmas/' . $firmaName;
        }

        $resultado = DB::select('CALL ActualizarProcesoSancion(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $request->numero_resolucion,
            $request->fecha_emision,
            $request->nombre_docente,
            $request->apellido_docente,
            $request->identificacion_docente,
            $request->asignatura,
            $request->calificacion_final,
            $request->tipo_sancion,
            $request->antecedentes,
            $request->fundamentos,
            $request->resolucion,
            $firmaPath
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Proceso de sanción actualizado exitosamente',
            'rows_updated' => $resultado[0]->rows_updated ?? 0
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Verificar si el proceso existe
        $procesos = DB::select('CALL ObtenerProcesoSancionPorId(?)', [$id]);
        $proceso = $procesos[0] ?? null;
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de sanción no encontrado'], 404);
        }

        // Eliminar firma si existe
        if ($proceso->firma_path) {
            Storage::delete('public/' . $proceso->firma_path);
        }

        $resultado = DB::select('CALL EliminarProcesoSancion(?)', [$id]);

        return response()->json([
            'success' => true,
            'message' => 'Proceso de sanción eliminado exitosamente',
            'rows_deleted' => $resultado[0]->rows_deleted ?? 0
        ]);
    }

    /**
     * Busca procesos de sanción por nombre de docente
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscarPorDocente(Request $request)
    {
        $nombre = $request->input('nombre');
        $procesos = DB::select('CALL BuscarProcesoSancionPorDocente(?)', [$nombre]);
        return response()->json($procesos);
    }
    
    /**
     * Filtra procesos de sanción por tipo
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filtrarPorTipo(Request $request)
    {
        $tipo = $request->input('tipo_sancion');
        $procesos = DB::select('CALL FiltrarProcesoSancionPorTipo(?)', [$tipo]);
        return response()->json($procesos);
    }
    
    /**
     * Filtra procesos de sanción por rango de calificación
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filtrarPorCalificacion(Request $request)
    {
        $min = $request->input('calificacion_min');
        $max = $request->input('calificacion_max');
        $procesos = DB::select('CALL FiltrarProcesoSancionPorCalificacion(?, ?)', [$min, $max]);
        return response()->json($procesos);
    }
    
    /**
     * Marca un proceso de sanción como enviado
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enviar($id)
    {
        // Verificar si el proceso existe
        $procesos = DB::select('CALL ObtenerProcesoSancionPorId(?)', [$id]);
        $proceso = $procesos[0] ?? null;
        
        if (!$proceso) {
            return response()->json(['error' => 'Proceso de sanción no encontrado'], 404);
        }

        $resultado = DB::select('CALL MarcarProcesoSancionComoEnviado(?)', [$id]);

        return response()->json([
            'success' => true,
            'message' => 'Proceso de sanción enviado exitosamente',
            'rows_updated' => $resultado[0]->rows_updated ?? 0
        ]);
    }
    
    /**
     * Obtiene docentes con calificaciones bajas
     * 
     * @return \Illuminate\Http\Response
     */
    public function docentesBajoDesempeno()
    {
        $docentesBajoDesempeno = DB::select('CALL ObtenerDocentesCalificacionesBajas(?)', [3.00]);
        return response()->json($docentesBajoDesempeno);
    }
}