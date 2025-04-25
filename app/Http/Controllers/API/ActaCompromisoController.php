<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ActaCompromiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ActaCompromisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actas = ActaCompromiso::all();
        return response()->json([
            'success' => true,
            'data' => $actas
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
            'numero_acta' => 'required|string|unique:acta_compromiso,numero_acta',
            'fecha_generacion' => 'required|date',
            'nombre_docente' => 'required|string|max:255',
            'apellido_docente' => 'required|string|max:255',
            'identificacion_docente' => 'required|string|max:20',
            'asignatura' => 'required|string|max:255',
            'calificacion_final' => 'required|numeric|between:0,5.00',
            'retroalimentacion' => 'required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $firmaPath = null;
        if ($request->hasFile('firma')) {
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $firmaPath = 'firmas/' . $firmaName;
        }

        $acta = ActaCompromiso::create([
            'numero_acta' => $request->numero_acta,
            'fecha_generacion' => $request->fecha_generacion,
            'nombre_docente' => $request->nombre_docente,
            'apellido_docente' => $request->apellido_docente,
            'identificacion_docente' => $request->identificacion_docente,
            'asignatura' => $request->asignatura,
            'calificacion_final' => $request->calificacion_final,
            'retroalimentacion' => $request->retroalimentacion,
            'firma_path' => $firmaPath,
            'enviado' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Acta de compromiso creada exitosamente',
            'data' => $acta
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
        $acta = ActaCompromiso::find($id);
        
        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta de compromiso no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $acta
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
        $acta = ActaCompromiso::find($id);
        
        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta de compromiso no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'numero_acta' => 'sometimes|required|string|unique:acta_compromiso,numero_acta,' . $id,
            'fecha_generacion' => 'sometimes|required|date',
            'nombre_docente' => 'sometimes|required|string|max:255',
            'apellido_docente' => 'sometimes|required|string|max:255',
            'identificacion_docente' => 'sometimes|required|string|max:20',
            'asignatura' => 'sometimes|required|string|max:255',
            'calificacion_final' => 'sometimes|required|numeric|between:0,5.00',
            'retroalimentacion' => 'sometimes|required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'enviado' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('firma')) {
            // Eliminar firma anterior si existe
            if ($acta->firma_path) {
                Storage::delete('public/' . $acta->firma_path);
            }
            
            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $acta->firma_path = 'firmas/' . $firmaName;
        }

        if ($request->has('numero_acta')) $acta->numero_acta = $request->numero_acta;
        if ($request->has('fecha_generacion')) $acta->fecha_generacion = $request->fecha_generacion;
        if ($request->has('nombre_docente')) $acta->nombre_docente = $request->nombre_docente;
        if ($request->has('apellido_docente')) $acta->apellido_docente = $request->apellido_docente;
        if ($request->has('identificacion_docente')) $acta->identificacion_docente = $request->identificacion_docente;
        if ($request->has('asignatura')) $acta->asignatura = $request->asignatura;
        if ($request->has('calificacion_final')) $acta->calificacion_final = $request->calificacion_final;
        if ($request->has('retroalimentacion')) $acta->retroalimentacion = $request->retroalimentacion;
        if ($request->has('enviado')) $acta->enviado = $request->enviado;

        $acta->save();

        return response()->json([
            'success' => true,
            'message' => 'Acta de compromiso actualizada exitosamente',
            'data' => $acta
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
        $acta = ActaCompromiso::find($id);
        
        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta de compromiso no encontrada'
            ], 404);
        }

        // Eliminar firma si existe
        if ($acta->firma_path) {
            Storage::delete('public/' . $acta->firma_path);
        }

        $acta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Acta de compromiso eliminada exitosamente'
        ]);
    }

    /**
     * Update the sent status of the acta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enviar($id)
    {
        $acta = ActaCompromiso::find($id);
        
        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta de compromiso no encontrada'
            ], 404);
        }

        $acta->enviado = true;
        $acta->save();

        return response()->json([
            'success' => true,
            'message' => 'Acta de compromiso marcada como enviada',
            'data' => $acta
        ]);
    }
}