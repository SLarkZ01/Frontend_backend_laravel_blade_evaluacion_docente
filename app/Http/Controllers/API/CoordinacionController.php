<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coordinacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoordinacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coordinaciones = Coordinacion::with('facultades')->get();
        return response()->json([
            'success' => true,
            'data' => $coordinaciones
        ]);
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
            'nombre' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $coordinacion = Coordinacion::create([
            'nombre' => $request->nombre
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coordinación creada exitosamente',
            'data' => $coordinacion
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
        $coordinacion = Coordinacion::with('facultades')->find($id);
        
        if (!$coordinacion) {
            return response()->json([
                'success' => false,
                'message' => 'Coordinación no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $coordinacion
        ]);
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
        $coordinacion = Coordinacion::find($id);
        
        if (!$coordinacion) {
            return response()->json([
                'success' => false,
                'message' => 'Coordinación no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $coordinacion->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Coordinación actualizada exitosamente',
            'data' => $coordinacion
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
        $coordinacion = Coordinacion::find($id);
        
        if (!$coordinacion) {
            return response()->json([
                'success' => false,
                'message' => 'Coordinación no encontrada'
            ], 404);
        }

        // Check if there are related facultades before deleting
        if ($coordinacion->facultades()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la coordinación porque tiene facultades asociadas'
            ], 400);
        }

        $coordinacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coordinación eliminada exitosamente'
        ]);
    }

    /**
     * Get the facultades for a specific coordinacion.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function facultades($id)
    {
        $coordinacion = Coordinacion::find($id);
        
        if (!$coordinacion) {
            return response()->json([
                'success' => false,
                'message' => 'Coordinación no encontrada'
            ], 404);
        }

        $facultades = $coordinacion->facultades;

        return response()->json([
            'success' => true,
            'data' => $facultades
        ]);
    }
}