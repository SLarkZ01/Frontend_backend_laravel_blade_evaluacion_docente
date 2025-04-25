<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::all();
        return response()->json([
            'success' => true,
            'data' => $roles
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
            'nombre' => 'required|string|max:50|unique:rol',
            'descripcion' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $rol = new Rol();
        $rol->nombre = $request->nombre;
        $rol->descripcion = $request->descripcion;
        $rol->save();

        return response()->json([
            'success' => true,
            'message' => 'Rol creado exitosamente',
            'data' => $rol
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
        $rol = Rol::find($id);
        
        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $rol
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
        $rol = Rol::find($id);
        
        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:50|unique:rol,nombre,' . $id . ',id_rol',
            'descripcion' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('nombre')) $rol->nombre = $request->nombre;
        if ($request->has('descripcion')) $rol->descripcion = $request->descripcion;
        
        $rol->save();

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado exitosamente',
            'data' => $rol
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
        $rol = Rol::find($id);
        
        if (!$rol) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }

        // Check if the role is being used by any users before deleting
        $usersWithRole = \App\Models\Usuario::where('id_rol', $id)->count();
        if ($usersWithRole > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el rol porque está siendo utilizado por usuarios'
            ], 400);
        }

        $rol->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado exitosamente'
        ]);
    }
}