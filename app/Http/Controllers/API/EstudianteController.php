<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes = Estudiante::with('programa')->get();
        return response()->json([
            'success' => true,
            'data' => $estudiantes
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
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:Estudiantes,correo',
            'semestre' => 'required|integer|min:1|max:10',
            'id_programa' => 'required|exists:Programas,id_programa'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $estudiante = Estudiante::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'semestre' => $request->semestre,
            'id_programa' => $request->id_programa
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estudiante creado exitosamente',
            'data' => $estudiante
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
        $estudiante = Estudiante::with('programa')->find($id);
        
        if (!$estudiante) {
            return response()->json([
                'success' => false,
                'message' => 'Estudiante no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $estudiante
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
        $estudiante = Estudiante::find($id);
        
        if (!$estudiante) {
            return response()->json([
                'success' => false,
                'message' => 'Estudiante no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'correo' => 'email|unique:Estudiantes,correo,' . $id . ',id_estudiante',
            'semestre' => 'integer|min:1|max:10',
            'id_programa' => 'exists:Programas,id_programa'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $estudiante->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Estudiante actualizado exitosamente',
            'data' => $estudiante
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
        $estudiante = Estudiante::find($id);
        
        if (!$estudiante) {
            return response()->json([
                'success' => false,
                'message' => 'Estudiante no encontrado'
            ], 404);
        }

        $estudiante->delete();

        return response()->json([
            'success' => true,
            'message' => 'Estudiante eliminado exitosamente'
        ]);
    }

    /**
     * Get estudiantes by programa ID.
     *
     * @param  int  $id_programa
     * @return \Illuminate\Http\Response
     */
    public function byPrograma($id_programa)
    {
        $estudiantes = Estudiante::where('id_programa', $id_programa)->get();
        
        return response()->json([
            'success' => true,
            'data' => $estudiantes
        ]);
    }
}