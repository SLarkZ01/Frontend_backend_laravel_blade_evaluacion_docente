<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of evaluaciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // Obtener todas las evaluaciones
        $evaluaciones = DB::select('CALL ObtenerTodasLasEvaluaciones()');
        
        return response()->json([
            'success' => true,
            'data' => $evaluaciones
        ]);
    }

    /**
     * Display the specified evaluacion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        // Validar formato de ID
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Formato de ID inválido',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Obtener evaluación por ID
        $evaluacion = DB::select('CALL ObtenerEvaluacionPorId(?)', [$id]);
        
        if (empty($evaluacion)) {
            return response()->json([
                'success' => false,
                'message' => 'Evaluación no encontrada'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $evaluacion[0]
        ]);
    }

    /**
     * Get evaluaciones by periodo.
     *
     * @param  string  $periodo
     * @return \Illuminate\Http\Response
     */
    public function byPeriodo($periodo)
    {        
        // Validar formato de periodo
        $validator = Validator::make(['periodo' => $periodo], [
            'periodo' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Formato de periodo inválido',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Obtener evaluaciones por periodo
        $evaluaciones = DB::select('CALL ObtenerEvaluacionesPorPeriodo(?)', [$periodo]);
        
        return response()->json([
            'success' => true,
            'data' => $evaluaciones
        ]);
    }

    /**
     * Get evaluaciones by facultad.
     *
     * @param  string  $facultad
     * @return \Illuminate\Http\Response
     */
    public function byFacultad($facultad)
    {        
        // Validar formato de facultad
        $validator = Validator::make(['facultad' => $facultad], [
            'facultad' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Formato de facultad inválido',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Obtener evaluaciones por facultad
        $evaluaciones = DB::select('CALL ObtenerEvaluacionesPorFacultad(?)', [$facultad]);
        
        return response()->json([
            'success' => true,
            'data' => $evaluaciones
        ]);
    }

    /**
     * Get estadísticas de evaluaciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function estadisticas()
    {        
        // Obtener estadísticas generales de evaluaciones
        $estadisticas = DB::select('CALL ObtenerEstadisticasEvaluaciones()');
        
        return response()->json([
            'success' => true,
            'data' => $estadisticas
        ]);
    }
}