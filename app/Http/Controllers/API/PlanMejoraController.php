<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlanMejoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $planes = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $planes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los planes de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
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
            'id_facultad' => 'required|exists:facultad,id_facultad',
            'id_curso' => 'required|exists:cursos,id_curso',
            'id_docente' => 'required|exists:docente,id_docente',
            'id_promedio' => 'required|exists:promedio_evaluacion_docente_por_curso,id_promedio',
            'progreso' => 'required|integer|min:0|max:100',
            'estado' => 'required|in:Activo,Cerrado,Pendiente',
            'retroalimentacion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $planId = DB::table('plan_de_mejora')->insertGetId([
                'id_facultad' => $request->id_facultad,
                'id_curso' => $request->id_curso,
                'id_docente' => $request->id_docente,
                'id_promedio' => $request->id_promedio,
                'progreso' => $request->progreso,
                'estado' => $request->estado,
                'retroalimentacion' => $request->retroalimentacion
            ]);

            $planCreado = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('plan_de_mejora.id_plan_mejora', $planId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Plan de mejora creado exitosamente',
                'data' => $planCreado
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el plan de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $plan = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('plan_de_mejora.id_plan_mejora', $id)
                ->first();
            
            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan de mejora no encontrado'
                ], 404);
            }

            // Obtener las notas asociadas al plan de mejora
            $notas = DB::table('notas_plan_mejora')
                ->where('id_plan_mejora', $id)
                ->orderBy('fecha', 'desc')
                ->get();

            $plan->notas = $notas;

            return response()->json([
                'success' => true,
                'data' => $plan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el plan de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
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
            'id_facultad' => 'sometimes|required|exists:facultad,id_facultad',
            'id_curso' => 'sometimes|required|exists:cursos,id_curso',
            'id_docente' => 'sometimes|required|exists:docente,id_docente',
            'id_promedio' => 'sometimes|required|exists:promedio_evaluacion_docente_por_curso,id_promedio',
            'progreso' => 'sometimes|required|integer|min:0|max:100',
            'estado' => 'sometimes|required|in:Activo,Cerrado,Pendiente',
            'retroalimentacion' => 'sometimes|required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $plan = DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->first();
            
            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan de mejora no encontrado'
                ], 404);
            }

            $updateData = [];
            if ($request->has('id_facultad')) $updateData['id_facultad'] = $request->id_facultad;
            if ($request->has('id_curso')) $updateData['id_curso'] = $request->id_curso;
            if ($request->has('id_docente')) $updateData['id_docente'] = $request->id_docente;
            if ($request->has('id_promedio')) $updateData['id_promedio'] = $request->id_promedio;
            if ($request->has('progreso')) $updateData['progreso'] = $request->progreso;
            if ($request->has('estado')) $updateData['estado'] = $request->estado;
            if ($request->has('retroalimentacion')) $updateData['retroalimentacion'] = $request->retroalimentacion;

            DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->update($updateData);

            $planActualizado = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('plan_de_mejora.id_plan_mejora', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Plan de mejora actualizado exitosamente',
                'data' => $planActualizado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el plan de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $plan = DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->first();
            
            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan de mejora no encontrado'
                ], 404);
            }

            // Eliminar primero las notas asociadas al plan
            DB::table('notas_plan_mejora')
                ->where('id_plan_mejora', $id)
                ->delete();

            // Luego eliminar el plan
            DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan de mejora eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plan de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a note to a plan de mejora.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNota(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nota' => 'required|string',
            'fecha' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $plan = DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->first();
            
            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan de mejora no encontrado'
                ], 404);
            }

            $notaId = DB::table('notas_plan_mejora')->insertGetId([
                'id_plan_mejora' => $id,
                'nota' => $request->nota,
                'fecha' => $request->fecha
            ]);

            $notaCreada = DB::table('notas_plan_mejora')
                ->where('id_notas_plan_mejora', $notaId)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Nota agregada exitosamente al plan de mejora',
                'data' => $notaCreada
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar nota al plan de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get plans by docente.
     *
     * @param  int  $id_docente
     * @return \Illuminate\Http\Response
     */
    public function getPlansByDocente($id_docente)
    {
        try {
            $planes = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('plan_de_mejora.id_docente', $id_docente)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $planes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los planes de mejora del docente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get plans by facultad.
     *
     * @param  int  $id_facultad
     * @return \Illuminate\Http\Response
     */
    public function getPlansByFacultad($id_facultad)
    {
        try {
            $planes = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('plan_de_mejora.id_facultad', $id_facultad)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $planes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los planes de mejora de la facultad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the progress of a plan de mejora.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProgress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'progreso' => 'required|integer|min:0|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $plan = DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->first();
            
            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan de mejora no encontrado'
                ], 404);
            }

            DB::table('plan_de_mejora')
                ->where('id_plan_mejora', $id)
                ->update(['progreso' => $request->progreso]);

            // Si el progreso es 100%, actualizar el estado a 'Cerrado'
            if ($request->progreso == 100) {
                DB::table('plan_de_mejora')
                    ->where('id_plan_mejora', $id)
                    ->update(['estado' => 'Cerrado']);
            }

            $planActualizado = DB::table('plan_de_mejora')
                ->join('docente', 'plan_de_mejora.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'plan_de_mejora.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'plan_de_mejora.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'plan_de_mejora.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('plan_de_mejora.id_plan_mejora', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Progreso del plan de mejora actualizado exitosamente',
                'data' => $planActualizado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el progreso del plan de mejora',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}