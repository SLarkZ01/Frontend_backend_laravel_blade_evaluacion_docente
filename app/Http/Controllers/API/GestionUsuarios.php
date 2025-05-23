<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class GestionUsuarios extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $usuarios = DB::select("CALL ObtenerTodosLosUsuarios()");

            return response()->json($usuarios, 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al obtener la lista de usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6',
            'id_rol' => 'required|integer',
            'tipo_usuario' => 'required|string|in:docente,coordinador,administrador',
            'activo' => 'required|boolean',
            'identificacion' => 'required|string|max:255',
        ]);

        try {
            // Llamada al procedimiento SIN parámetro de salida
            DB::statement("CALL CrearUsuario(?, ?, ?, ?, ?, ?, ?, ?)", [
                $request->id_rol,
                $request->activo,
                $request->nombre,
                $request->apellido,
                $request->correo,
                $request->contrasena,
                $request->identificacion,
                $request->tipo_usuario
            ]);

            return response()->json([
                'mensaje' => 'Usuario creado exitosamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nombre): JsonResponse
    {
        try {
            // Llamar al procedimiento almacenado para buscar por nombre
            $usuarios = DB::select("CALL ObtenerUsuarioPorNombre(?)", [$nombre]);

            if (empty($usuarios)) {
                return response()->json([
                    'mensaje' => 'No se encontraron usuarios con ese nombre'
                ], 404);
            }

            return response()->json($usuarios, 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al buscar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email',
            'id_rol' => 'required|integer',
            'tipo_usuario' => 'required|in:docente,coordinador,administrador',
            'activo' => 'required|boolean',
        ]);

        try {
            // Llamar al procedimiento almacenado para actualizar el usuario
            DB::statement("CALL ActualizarUsuarioInfo(?, ?, ?, ?, ?, ?)", [
                $id,
                $request->nombre,
                $request->correo,
                $request->id_rol,
                $request->tipo_usuario,
                $request->activo
            ]);

            return response()->json([
                'mensaje' => 'Usuario actualizado correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al actualizar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            // Llamar al procedimiento almacenado para eliminar el usuario
            DB::statement("CALL EliminarUsuario(?)", [$id]);

            return response()->json([
                'mensaje' => 'Usuario eliminado correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => 'Error al eliminar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}