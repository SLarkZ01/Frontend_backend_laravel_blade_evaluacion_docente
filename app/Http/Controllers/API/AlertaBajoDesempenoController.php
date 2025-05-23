<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlertaBajoDesempenoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $alertas = DB::table('alertas_bajo_desempeno')
                ->join('docente', 'alertas_bajo_desempeno.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'alertas_bajo_desempeno.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'alertas_bajo_desempeno.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'alertas_bajo_desempeno.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => $alertas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las alertas de bajo desempeño',
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
            'id_promedio' => 'required|exists:promedio_evaluacion_docente_por_curso,id_promedio',
            'id_docente' => 'required|exists:docente,id_docente',
            'id_curso' => 'required|exists:cursos,id_curso',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $alerta = DB::table('alertas_bajo_desempeno')->insertGetId([
                'id_facultad' => $request->id_facultad,
                'id_promedio' => $request->id_promedio,
                'id_docente' => $request->id_docente,
                'id_curso' => $request->id_curso,
            ]);

            $alertaCreada = DB::table('alertas_bajo_desempeno')
                ->join('docente', 'alertas_bajo_desempeno.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'alertas_bajo_desempeno.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'alertas_bajo_desempeno.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'alertas_bajo_desempeno.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('alertas_bajo_desempeno.id_alerta', $alerta)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Alerta de bajo desempeño creada exitosamente',
                'data' => $alertaCreada
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la alerta de bajo desempeño',
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
            $alerta = DB::table('alertas_bajo_desempeno')
                ->join('docente', 'alertas_bajo_desempeno.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'alertas_bajo_desempeno.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'alertas_bajo_desempeno.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'alertas_bajo_desempeno.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('alertas_bajo_desempeno.id_alerta', $id)
                ->first();
            
            if (!$alerta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alerta de bajo desempeño no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $alerta
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la alerta de bajo desempeño',
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
            'id_promedio' => 'sometimes|required|exists:promedio_evaluacion_docente_por_curso,id_promedio',
            'id_docente' => 'sometimes|required|exists:docente,id_docente',
            'id_curso' => 'sometimes|required|exists:cursos,id_curso',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $alerta = DB::table('alertas_bajo_desempeno')
                ->where('id_alerta', $id)
                ->first();
            
            if (!$alerta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alerta de bajo desempeño no encontrada'
                ], 404);
            }

            $updateData = [];
            if ($request->has('id_facultad')) $updateData['id_facultad'] = $request->id_facultad;
            if ($request->has('id_promedio')) $updateData['id_promedio'] = $request->id_promedio;
            if ($request->has('id_docente')) $updateData['id_docente'] = $request->id_docente;
            if ($request->has('id_curso')) $updateData['id_curso'] = $request->id_curso;

            DB::table('alertas_bajo_desempeno')
                ->where('id_alerta', $id)
                ->update($updateData);

            $alertaActualizada = DB::table('alertas_bajo_desempeno')
                ->join('docente', 'alertas_bajo_desempeno.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'alertas_bajo_desempeno.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'alertas_bajo_desempeno.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'alertas_bajo_desempeno.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('alertas_bajo_desempeno.id_alerta', $id)
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Alerta de bajo desempeño actualizada exitosamente',
                'data' => $alertaActualizada
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la alerta de bajo desempeño',
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
            $alerta = DB::table('alertas_bajo_desempeno')
                ->where('id_alerta', $id)
                ->first();
            
            if (!$alerta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alerta de bajo desempeño no encontrada'
                ], 404);
            }

            DB::table('alertas_bajo_desempeno')
                ->where('id_alerta', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alerta de bajo desempeño eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la alerta de bajo desempeño',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get alerts by docente.
     *
     * @param  int  $id_docente
     * @return \Illuminate\Http\Response
     */
    public function getAlertasByDocente($id_docente)
    {
        try {
            $alertas = DB::table('alertas_bajo_desempeno')
                ->join('docente', 'alertas_bajo_desempeno.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'alertas_bajo_desempeno.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'alertas_bajo_desempeno.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'alertas_bajo_desempeno.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('alertas_bajo_desempeno.id_docente', $id_docente)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $alertas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las alertas de bajo desempeño del docente',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get alerts by facultad.
     *
     * @param  int  $id_facultad
     * @return \Illuminate\Http\Response
     */
    public function getAlertasByFacultad($id_facultad)
    {
        try {
            $alertas = DB::table('alertas_bajo_desempeno')
                ->join('docente', 'alertas_bajo_desempeno.id_docente', '=', 'docente.id_docente')
                ->join('cursos', 'alertas_bajo_desempeno.id_curso', '=', 'cursos.id_curso')
                ->join('facultad', 'alertas_bajo_desempeno.id_facultad', '=', 'facultad.id_facultad')
                ->select(
                    'alertas_bajo_desempeno.*',
                    'docente.nombre as nombre_docente',
                    'cursos.nombre as nombre_curso',
                    'facultad.nombre as nombre_facultad'
                )
                ->where('alertas_bajo_desempeno.id_facultad', $id_facultad)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $alertas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las alertas de bajo desempeño de la facultad',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}