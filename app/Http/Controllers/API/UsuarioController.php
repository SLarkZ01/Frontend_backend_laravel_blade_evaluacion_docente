<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    try {
        $usuarios = DB::select("CALL ObtenerTodosLosUsuarios()");
        return response(view('roles_permisos', compact('usuarios'))); // 👈 Vista Blade
    } catch (\Exception $e) {
        return response()->view('errors.general', ['error' => $e->getMessage()], 500);
    }
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'data' => $request->all()
        ], 201);

        //     return response()->json([
        //         'mensaje' => 'Usuario creado exitosamente'
        //     ], 201);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'mensaje' => 'Error al crear el usuario',
        //         'error' => $e->getMessage()
        //     ], 500);
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
        $usuario = Usuario::find($id);
        
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $usuario
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
 * Update the specified resource in storage.
 */
/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id): JsonResponse
{
    try {
        // Validación básica
        $rules = [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email',
            'id_rol' => 'required|integer',
            'tipo_usuario' => 'required|string|in:docente,coordinador,administrador',
            'activo' => 'required|boolean',
        ];
        
        // Si se incluye contraseña, validarla
        if ($request->has('contrasena') && !empty($request->contrasena)) {
            $rules['contrasena'] = 'required|string|min:6';
        }
        
        $validatedData = $request->validate($rules);

        // Opción 1: Si actualizaste el procedimiento para incluir apellido
        if ($request->has('apellido')) {
            DB::statement("CALL ActualizarUsuarioInfo(?, ?, ?, ?, ?, ?, ?)", [
                $id,
                $request->nombre,
                $request->apellido,
                $request->correo,
                $request->id_rol,
                $request->tipo_usuario,
                $request->activo
            ]);
        } else {
            // Opción 2: Si mantienes el procedimiento actual (sin apellido)
            DB::statement("CALL ActualizarUsuarioInfo(?, ?, ?, ?, ?, ?)", [
                $id,
                $request->nombre,
                $request->correo,
                $request->id_rol,
                $request->tipo_usuario,
                $request->activo
            ]);
        }
        
        // Si se debe actualizar la contraseña
        if ($request->has('contrasena') && !empty($request->contrasena)) {
            $contrasenaHash = bcrypt($request->contrasena);
            DB::statement("CALL ActualizarPasswordUsuario(?, ?)", [
                $id,
                $contrasenaHash
            ]);
        }

        return response()->json([
            'mensaje' => 'Usuario actualizado correctamente'
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'mensaje' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'mensaje' => 'Error al actualizar el usuario',
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
        $usuario = Usuario::find($id);
        
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }
}