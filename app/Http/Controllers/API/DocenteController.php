<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocenteController extends Controller
{
    /**
     * Display a listing of docentes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // Obtener todos los usuarios con rol de docente
        $docentes = DB::select('CALL ObtenerTodosLosDocentes()');
        
        return response()->json([
            'success' => true,
            'data' => $docentes
        ]);
    }

    /**
     * Display the specified docente.
     *
     * @param  string  $correo
     * @return \Illuminate\Http\Response
     */
    public function show($correo)
    {        
        // Validar formato de correo
        $validator = Validator::make(['correo' => $correo], [
            'correo' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Formato de correo inválido',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Obtener docente por correo
        $docente = DB::select('CALL ObtenerDocentePorCorreo(?)', [$correo]);
        
        if (empty($docente)) {
            return response()->json([
                'success' => false,
                'message' => 'Docente no encontrado'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $docente[0]
        ]);
    }

    /**
     * Get evaluaciones for a specific docente.
     *
     * @param  string  $correo
     * @return \Illuminate\Http\Response
     */
    public function evaluaciones($correo)
    {        
        // Validar formato de correo
        $validator = Validator::make(['correo' => $correo], [
            'correo' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Formato de correo inválido',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Obtener evaluaciones del docente
        $evaluaciones = DB::select('CALL ObtenerEvaluacionesPorCorreo(?)', [$correo]);
        
        return response()->json([
            'success' => true,
            'data' => $evaluaciones
        ]);
    }

    /**
     * Update docente profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        // Buscar el usuario docente
        $docente = Usuario::find($id);
        
        if (!$docente) {
            return response()->json([
                'success' => false,
                'message' => 'Docente no encontrado'
            ], 404);
        }

        // Validar datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'correo' => 'sometimes|required|email|max:255|unique:usuarios,correo,' . $id . ',id_usuario',
            'contrasena' => 'sometimes|required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Actualizar datos
        if ($request->has('nombre')) {
            $docente->nombre = $request->nombre;
        }
        
        if ($request->has('correo')) {
            $docente->correo = $request->correo;
        }
        
        if ($request->has('contrasena')) {
            $docente->contrasena = $request->contrasena; // Consider hashing this password
        }
        
        $docente->save();

        return response()->json([
            'success' => true,
            'message' => 'Perfil de docente actualizado exitosamente',
            'data' => $docente
        ]);
    }
}