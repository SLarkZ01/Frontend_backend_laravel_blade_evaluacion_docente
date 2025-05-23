<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEvaluacionRequest;

class EvaluacionController extends Controller
{
    /**
     * Estados de evaluación que se deben excluir
     */
    const ESTADOS_EXCLUIDOS = ['eliminado', 'cancelado', 'completado', 'en proceso'];

    /**
     * Muestra la lista de evaluaciones utilizando procedimientos almacenados
     */
    public function index()
    {
        $evaluaciones = DB::select('CALL sp_listar_evaluaciones()');
        $facultades = DB::table('facultades')->get();

        return view('Decano.proceso_sancion_retiro', compact('evaluaciones', 'facultades'));
    }

    /**
     * Muestra el formulario para crear una nueva evaluación
     */
    public function create()
    {
        $departamentos = DB::table('departamentos')->get();
        return view('evaluaciones.create', compact('departamentos'));
    }

    /**
     * Almacena una nueva evaluación en la base de datos utilizando procedimientos almacenados
     */
    // public function store(Store $request)
    // {
    //     DB::select('CALL sp_crear_evaluacion(?, ?, ?, ?, ?, ?, ?)', [
    //         $request->docente_id,
    //         $request->numero_resolucion,
    //         $request->fecha_emision,
    //         $request->asignatura,
    //         $request->calificacion_final,
    //         $request->tipo_sancion,
    //         $request->antecedentes_justificacion,
    //     ]);

    //     return redirect()->route('evaluaciones.proceso_sancion_retiro')
    //                      ->with('success', 'Evaluación creada exitosamente');
    // }
    public function store($request)
    {
        DB::select('CALL sp_crear_evaluacion(?, ?, ?, ?, ?, ?, ?)', [
            $request->docente_id,
            $request->numero_resolucion,
            $request->fecha_emision,
            $request->asignatura,
            $request->calificacion_final,
            $request->tipo_sancion,
            $request->antecedentes_justificacion,
        ]);

        return redirect()->route('evaluaciones.proceso_sancion_retiro')
                         ->with('success', 'Evaluación creada exitosamente');
    }
    /**
     * Muestra una evaluación específica
     */
    public function show($id)
    {
        $evaluacion = DB::table('evaluaciones')
            ->join('docentes', 'evaluaciones.docente_id', '=', 'docentes.id')
            ->join('departamentos', 'docentes.departamento_id', '=', 'departamentos.id')
            ->select(
                'evaluaciones.*',
                'docentes.nombre as docente_nombre',
                'docentes.apellido as docente_apellido',
                'docentes.identificacion as identificacion_docente',
                'docentes.asignatura as asignatura_docente',
                'docentes.promedio_total',
                'departamentos.nombre as departamento_nombre'
            )
            ->whereNotIn('evaluaciones.estado', self::ESTADOS_EXCLUIDOS)
            ->where('evaluaciones.id', $id)
            ->first();

        if (!$evaluacion) {
            return redirect()->route('evaluaciones.index')
                             ->with('error', 'Evaluación no encontrada');
        }

        return view('evaluaciones.show', compact('evaluacion'));
    }

    /**
     * Busca docentes según el criterio proporcionado utilizando procedimientos almacenados
     */
    public function buscarDocente(Request $request)
    {
        $query = $request->get('query');

        if (strlen($query) >= 3) {
            $docentes = DB::select('CALL sp_buscar_docente(?)', [$query]);
            return response()->json($docentes);
        }

        return response()->json([]);
    }

    /**
     * Filtra evaluaciones por departamento y rango de calificación
     */
    public function filtrarEvaluaciones(Request $request)
    {
        $departamento_id = $request->departamento_id !== 'todos' ? $request->departamento_id : null;

        $rangos = [
            'excelente' => [90, 100],
            'bueno' => [80, 89.99],
            'satisfactorio' => [70, 79.99],
            'insuficiente' => [0, 69.99],
        ];

        $calificacion_min = null;
        $calificacion_max = null;

        if (isset($rangos[$request->calificacion])) {
            [$calificacion_min, $calificacion_max] = $rangos[$request->calificacion];
        }

        $evaluaciones = DB::select('CALL sp_filtrar_evaluaciones(?, ?, ?)', [
            $departamento_id,
            $calificacion_min,
            $calificacion_max
        ]);

        return response()->json($evaluaciones);
    }
}
