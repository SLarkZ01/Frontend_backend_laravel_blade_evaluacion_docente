<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programas = Programa::with('facultad', 'docente')->get();
        return response()->json([
            'success' => true,
            'data' => $programas
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
            'id_facultad' => 'required|exists:Facultad,id_facultad',
            'id_docente' => 'nullable|exists:Docentes,id_docente'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $programa = Programa::create([
            'nombre' => $request->nombre,
            'id_facultad' => $request->id_facultad,
            'id_docente' => $request->id_docente
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Programa creado exitosamente',
            'data' => $programa
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
        $programa = Programa::with('facultad', 'docente')->find($id);
        
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Programa no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $programa
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
        $programa = Programa::find($id);
        
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Programa no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'id_facultad' => 'exists:Facultad,id_facultad',
            'id_docente' => 'nullable|exists:Docentes,id_docente'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $programa->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Programa actualizado exitosamente',
            'data' => $programa
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
        $programa = Programa::find($id);
        
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Programa no encontrado'
            ], 404);
        }

        $programa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Programa eliminado exitosamente'
        ]);
    }

    /**
     * Get the estudiantes for a specific programa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function estudiantes($id)
    {
        $programa = Programa::find($id);
        
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Programa no encontrado'
            ], 404);
        }

        $estudiantes = $programa->estudiantes;

        return response()->json([
            'success' => true,
            'data' => $estudiantes
        ]);
    }

    /**
     * Get the cursos for a specific programa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cursos($id)
    {
        $programa = Programa::find($id);
        
        if (!$programa) {
            return response()->json([
                'success' => false,
                'message' => 'Programa no encontrado'
            ], 404);
        }

        $cursos = $programa->cursos;

        return response()->json([
            'success' => true,
            'data' => $cursos
        ]);
    }
}