<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActaCompromisoController extends Controller
{
    /**
     * Display a listing of all actas de compromiso.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        
    $actas = DB::select('CALL GetActasCompromiso()');

    return response()->json([
        'success' => true,
        'data' => $actas,
        'message' => 'Actas de compromiso retrieved successfully'
    ]);
    }

    /**
     * Display the specified acta de compromiso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $acta = DB::select('CALL GetActaCompromisoById(?)', [$id]);
            
            if (empty($acta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acta de compromiso not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $acta[0],
                'message' => 'Acta de compromiso retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving acta de compromiso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created acta de compromiso in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'fecha_generacion' => 'required|date',
            'nombre_docente' => 'required|string',
            'apellido_docente' => 'required|string',
            'identificacion_docente' => 'required|string',
            'curso' => 'required|string',
            'promedio_total' => 'required|numeric',
            'retroalimentacion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = DB::select('CALL CreateActaCompromiso(?, ?, ?, ?, ?, ?, ?)', [
            $request->fecha_generacion,
            $request->nombre_docente,
            $request->apellido_docente,
            $request->identificacion_docente,
            $request->curso,
            $request->promedio_total,
            $request->retroalimentacion
        ]);
        
        

        return response()->json([
            'success' => true,
            'data' => $result[0],
            'message' => 'Acta de compromiso creada correctamente'
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al crear el acta de compromiso: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified acta de compromiso in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'retroalimentacion' => 'required|string',
                'fecha_generacion' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $result = DB::select('CALL UpdateActaCompromiso(?, ?, ?)', [
                $id,
                $request->retroalimentacion,
                $request->fecha_generacion
            ]);

            if ($result[0]->rows_updated == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acta de compromiso not found or no changes made'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Acta de compromiso updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating acta de compromiso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified acta de compromiso from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $result = DB::select('CALL DeleteActaCompromiso(?)', [$id]);

            if ($result[0]->rows_deleted == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acta de compromiso not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Acta de compromiso deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting acta de compromiso: ' . $e->getMessage()
            ], 500);
        }
    }
}