<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Calificacion;
use App\Models\AlertaBajoDesempeno;
use App\Models\Busquedadocente;
use App\Models\Facultad;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActaCompromiso;
use App\Models\ProcesoSancionRetiro;
use Carbon\Carbon;

class DecanoCordinadorController extends Controller
{
    //
    //total_docentes


        public function total_docentes()
    {
        $docentes = DB::select('CALL total_docentes()');
        return view('decano.total_docentes', compact('docentes'));
    }
    //total docentes no evaluados
    public function totalNoEvaluados()
    {
        // Ejecutamos el procedimiento almacenado para obtener el total de docentes no evaluados
        $totalNoEvaluados = DB::select('CALL totalNoEvaluados()');
        $totalNoEvaluados = $totalNoEvaluados[0] ?? null;
        // Pasamos la variable $totalNoEvaluados a la vista
        return view('decano.totalNoEvaluados', compact('totalNoEvaluados'));
    }
    public function totalEstudiantesNoEvaluaron()
    {
        // Ejecutamos el procedimiento almacenado para obtener el total de estudiantes no evaluados
        $totalEstudiantesNoEvaluaron = DB::select('CALL ObtenerTotalEstudiantesNoEvaluaron()');

        // Pasamos la variable $totalEstudiantesNoEvaluaron a la vista
        return view('decano.totalEstudiantesNoEvaluaron', compact('totalEstudiantesNoEvaluaron'));
    }
    //promedio por facultad
    public function promedio_global()
    {
        // Ejecutamos el procedimiento almacenado para obtener el promedio por facultad
        $promedio_global = DB::select('CALL promedio_global()');
        // Pasamos la variable $promedio_global a la vista
        return view('decano.promedio_global', compact('promedio_global'));
    }
    //promedio por facultad

    public function obtenerPromedioPorFacultad() {
        // Ejecutamos el procedimiento almacenado
    $datos = collect(DB::select('CALL ObtenerPromedioPorFacultad()'));
// Asegúrate de que devuelva: facultad, promedio_nota
    $labels = $datos->pluck('facultad');
    $notas = $datos->pluck('promedio_nota');

return view('graficas.facultades', compact('labels', 'promedio_nota'));

}

public function docentesDestacados()
{
    // Ejecutar el procedimiento almacenado
    $docentes = DB::select('CALL ObtenerDocentesDestacados()');

    // Verificar los datos obtenidos
    dd($docentes);  // Verifica los datos obtenidos de la base de datos

    // Filtrar los duplicados basados en el nombre del docente
    $docentesUnicos = collect($docentes)->unique('docente');

    // Verificar los datos después de filtrar duplicados
    dd($docentesUnicos);  // Verifica los datos después de filtrar duplicados

    // Pasar los docentes únicos a la vista
    return view('decano.docentesDestacados', compact('docentesUnicos'));
}
public function mostrarGrafica()
    {
        // Ejecuta el procedimiento almacenado
        $promedios = DB::select('CALL ObtenerPromedioNotasPorFacultad()');

        // Extrae las etiquetas (facultades) y los datos (promedios)
        return view('decano.mostrarGrafica',['evaluaciones' => $promedios]);
    }

    public function mostrarAlertas()
    {
        $alertas = DB::select('CALL ObtenerAlertasCalificacionesCriticas()');

        return view('tu_vista', compact('alertas'));
    }


//docentes destacados
    public function acta_compromiso()

    {   $id_docente = request('id_docente');
        $docentesbusqueda = DB::select('CALL BuscarDocente(?)', [$id_docente]);
        $actas = $response['data'] ?? [];
        return view('decano.acta_compromiso', compact('docentesbusqueda', 'actas'));
    }

    /**
     * Guarda una nueva acta de compromiso
     */

    /**
     * Filtra docentes según departamento y rango de calificación
     */
    public function filtrar_docentes(Request $request)
    {
        $query = Docente::query()->where('promedio_total', '<', 4.0);

        // Filtrar por departamento
        if ($request->has('id_facultad') && !empty($request->id_facultad)) {
            $query->where('id_curso', $request->id_curso);
        }

        // Filtrar por rango de calificación
        if ($request->has('calificacion') && !empty($request->promedio_total)) {
            switch ($request->calificacion) {
                case '1':
                    $query->where('promedio_total', '<', 2.0);
                    break;
                case '2':
                    $query->whereBetween('promedio_total', [2.0, 2.99]);
                    break;
                case '3':
                    $query->whereBetween('promedio_total', [3.0, 3.99]);
                    break;
                default:
                    break;
            }
        }

        $docentes = $query->orderBy('apellido_docente')->get();

        return response()->json([
            'docentes' => $docentes
        ]);
    }

//  public function guardar(Request $request)
//     {
//         // Validación de datos
//         $request->validate([
//             'numero_acta' => 'required|string|max:30|unique:acta_compromiso,numero_acta',
//             'fecha_generacion' => 'required|date',
//             'nombre_docente' => 'required|string|max:100',
//             'apellido_docente' => 'required|string|max:100',
//             'identificacion_docente' => 'required|string|max:20',
//             'curso' => 'required|string|max:100',
//             'promedio_total' => 'required|numeric|min:0|max:5',
//             'retroalimentacion' => 'required|string',
//             'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
//         ]);

//         try {
//             // Procesar la firma si se ha subido
//             $firmaPath = null;
//             if ($request->hasFile('firma')) {
//                 $firma = $request->file('firma');
//                 $firmaName = time() . '_' . $firma->getClientOriginalName();
//                 $firma->move(public_path('uploads/firmas'), $firmaName);
//                 $firmaPath = 'uploads/firmas/' . $firmaName;
//             }

//             // Crear el acta usando create() en lugar de new
//             $acta = ActaCompromiso::create([
//                 'numero_acta' => $request->numero_acta,
//                 'fecha_generacion' => $request->fecha_generacion,
//                 'nombre_docente' => $request->nombre_docente,
//                 'apellido_docente' => $request->apellido_docente,
//                 'identificacion_docente' => $request->identificacion_docente,
//                 'curso' => $request->curso,
//                 'promedio_total' => $request->promedio_total,
//                 'retroalimentacion' => $request->retroalimentacion,
//                 'firma' => $firmaPath, // Cambiado de firma_path a firma
//             ]);

//             return redirect()->route('decano.acta_compromiso')
//                 ->with('success', 'Acta de compromiso registrada correctamente');

//         } catch (\Exception $e) {
//             // Para debugging, mostrar el error completo
//             \Log::error('Error al guardar acta: ' . $e->getMessage());
//             \Log::error('Stack trace: ' . $e->getTraceAsString());
            
//             return redirect()->back()
//                 ->with('error', 'Error al registrar el acta: ' . $e->getMessage())
//                 ->withInput();
//         }
//     }

    // Método para ver una acta específica
    public function ver($id)
    {
        $acta = ActaCompromiso::findOrFail($id);
        return view('decano.ver_acta_compromiso', compact('acta'));
    }

    // Método para descargar el acta en PDF
    public function descargarPDF($id)
    {
        $acta = ActaCompromiso::findOrFail($id);

        // Implementar generación del PDF
        $pdf = PDF::loadView('pdf.acta_compromiso', compact('acta'));

        return $pdf->download('acta_compromiso_' . $acta->numero_acta . '.pdf');
    }

    // Método para eliminar un acta
    public function destroy($id)
    {
        try {
            $acta = ActaCompromiso::findOrFail($id);

            // Eliminar archivo de firma si existe
            if ($acta->firma && file_exists(public_path($acta->firma))) {
                unlink(public_path($acta->firma));
            }

            $acta->delete();

            return redirect()->route('decano.acta_compromiso')
                ->with('success', 'Acta de compromiso eliminada correctamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el acta: ' . $e->getMessage());
        }
    }
    /**
     * Muestra el formulario para editar un acta
     */
    public function editar_acta($id_acta)
    {
        $acta = ActaCompromiso::findOrFail($id_acta);
        $docentesbusqueda = DB::select('CALL BuscarDocente(?)',[$id_acta]);
        // Obtener el docente relacionado con el acta
        $docente = $acta->docente;
        return view('decano.acta_compromiso', compact('acta', 'docentesbusqueda'));
    }
public function listar_actas()
{
    $actas = ActaCompromiso::all();

    return view('decano.acta_compromiso', compact('actas'));
}
    /**
     * Actualiza un acta existente
     */
    public function actualizar_acta(Request $request, $id)
    {
        $acta = ActaCompromiso::find($id);

        if (!$acta) {
            return redirect()->route('decano.acta_compromiso')
                ->withErrors(['error' => 'Acta de compromiso no encontrada']);
        }

        $validator = Validator::make($request->all(), [
            'numero_acta' => 'required|string|unique:acta_compromiso,numero_acta,' . $id,
            'fecha_generacion' => 'required|date',
            'nombre_docente' => 'required|string|max:255',
            'apellido_docente' => 'required|string|max:255',
            'identificacion_docente' => 'required|string|max:20',
            'curso' => 'required|string|max:255',
            'calificacion_final' => 'required|numeric|between:0,5.00',
            'retroalimentacion' => 'required|string',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('firma')) {
            // Eliminar firma anterior si existe
            if ($acta->firma) {
                Storage::delete('public/' . $acta->firma);
            }

            $firma = $request->file('firma');
            $firmaName = time() . '_' . $firma->getClientOriginalName();
            $firma->storeAs('public/firmas', $firmaName);
            $acta->firma = 'firmas/' . $firmaName;
        }

        $acta->numero_acta = $request->numero_acta;
        $acta->fecha_generacion = $request->fecha_generacion;
        $acta->nombre_docente = $request->nombre_docente;
        $acta->apellido_docente = $request->apellido_docente;
        $acta->identificacion_docente = $request->identificacion_docente;
        $acta->curso = $request->curso;
        $acta->calificacion_final = $request->calificacion_final;
        $acta->retroalimentacion = $request->retroalimentacion;
        $acta->save();

        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso actualizada exitosamente');
    }

    /**
     * Elimina un acta
     */
    public function eliminar_acta($id)
{
    // Llama al procedimiento almacenado para obtener el acta
    $acta = DB::select('CALL obtener_acta_por_id(?)', [$id]);

    if (!empty($acta)) {
        $acta = $acta[0]; // Tomamos el primer resultado (uno solo)

        // Eliminar firma si existe
        // if (isset($acta->firma_path) && $acta->firma_path) {
        //     \Illuminate\Support\Facades\Storage::delete('public/' . $acta->firma_path);
        // }

        // Llamada al procedimiento para eliminar
     DB::statement('CALL eliminar_acta(?)', [$id]);
    }

    return redirect()->route('decano.acta_compromiso')
        ->with('success', 'Acta de compromiso eliminada exitosamente');
}

    /**
     * Marca un acta como enviada
     */
   public function enviar_acta($id)
{
    // Ejecutar el procedimiento almacenado para marcar como enviada
DB::statement('CALL marcar_acta_como_enviada(?)', [$id]);

    return redirect()->route('decano.acta_compromiso')
        ->with('success', 'Acta de compromiso enviada exitosamente');
}


//alertas bajo desempe
    public function abd()
    {

        $facultades = Facultad::all();
        $docentesAlerta = Docente::where('promedio_total', '<', 3.0)->count();

        return view('decano.alertasBajoDesempeno', [
            'facultades' => $facultades,
            'docentesAlerta' => $docentesAlerta
        ]);
    }



    //modales seguimiento
    public function seguimiento()
    {
        return view('decano.modales_seguimiento');
    }

    //proseso sancion retiro

    public function psr()

    {



        return view('decano.proceso_sancion_retiro');
    }

    //seguimiento plan de mejora
    public function spm()
    {

        return view('decano.seguimiento_plan_mejora');
    }

    /**
     * Muestra el formulario para editar un acta de compromiso
     */
    public function editarActa($id)
    {
        // Obtener el acta de compromiso por ID usando el procedimiento almacenado
        $actas = DB::select('CALL GetActaCompromisoById(?)', [$id]);
        $acta = $actas[0] ?? null;

        if (!$acta) {
            return redirect()->route('decano.acta_compromiso')
                ->with('error', 'Acta de compromiso no encontrada');
        }

        // La información del docente ya viene incluida en el resultado del procedimiento almacenado
        $docente = (object)[
            'id_docente' => $acta->id_docente,
            'nombre' => $acta->nombre_docente,
        ];

        return view('decano.editar_acta', compact('acta', 'docente'));
    }

    /**
     * Actualiza un acta de compromiso en la base de datos
     */
    public function ActualizarActa(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'numero_acta' => 'required|string',
            'fecha_generacion' => 'required|date',
            'retroalimentacion' => 'required|string'
        ]);

        // Actualizar el acta en la base de datos usando el procedimiento almacenado
        $result = DB::select('CALL UpdateActaCompromiso(?, ?, ?)', [
            $id,
            $request->retroalimentacion,
            $request->fecha_generacion
        ]);

        // Si se cargó una nueva firma, procesarla y actualizar el campo de firma por separado
        if ($request->hasFile('firma')) {
            $firma = $request->file('firma');
            $nombreFirma = time() . '_' . $firma->getClientOriginalName();
            $firma->move(public_path('firmas'), $nombreFirma);

            // Actualizar solo el campo de firma
            DB::table('acta_compromiso')
                ->where('id_acta', $id)
                ->update(['firma' => '/firmas/' . $nombreFirma]);
        } elseif ($request->has('firma_actual')) {
            // Actualizar solo el campo de firma con el valor actual
            DB::table('acta_compromiso')
                ->where('id_acta', $id)
                ->update(['firma' => $request->firma_actual]);
        }

        return redirect()->route('decano.acta_compromiso')
            ->with('success', 'Acta de compromiso actualizada correctamente');
    }
    public function descargar()
{
    $path = storage_path('app/public/actas/acta_compromiso.pdf'); // Ajusta la ruta según corresponda

    if (!file_exists($path)) {
        abort(404, 'Archivo no encontrado');
    }

    return response()->download($path, 'acta_compromiso.pdf');
}
public function mostrarFormularioSancion()
    {
        // Obtener todos los docentes disponibles para la sanción
        $docentesbusqueda = DB::select('CALL BuscarDocente(?)', ['']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            // "" para traer todos

        return view('decano.formulario_sancion', compact('docentesbusqueda'));
    }
    /**
     * Almacena una nueva sanción en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardarSancion(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_docente' => 'required|exists:docentes,id',
            'numero_resolucion' => 'required|string|max:50|unique:proceso_sancion_retiro,numero_resolucion',
            'fecha_emision' => 'required|date',
            'curso' => 'required|string|max:100',
            'calificacion_final' => 'required|numeric|min:0|max:100',
            'tipo_sancion' => 'required|in:leve,grave,retiro',
            'antecedentes' => 'required|string',
            'fundamentos' => 'required|string',
            'resolucion' => 'required|string',
            'firma' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Buscar los datos del docente desde el procedimiento almacenado
            $docenteData = DB::select('CALL BuscarDocente(?)', [$request->id_docente]);

            if (empty($docenteData)) {
                return back()->with('error', 'No se encontró información del docente.');
            }

            $docente = $docenteData[0]; // Solo se espera un resultado

            // Procesar la firma
            $firmaPath = null;
            if ($request->hasFile('firma')) {
                $firma = $request->file('firma');
                $firmaPath = $firma->storeAs(
                    'firmas',
                    uniqid('firma_') . '.' . $firma->getClientOriginalExtension(),
                    'public'
                );
            }

            // Crear la sanción directamente en la tabla proceso_sancion_retiro
            $sancion = DB::table('proceso_sancion_retiro')->insertGetId([
                'docente_id' => $request->id_docente,
                'nombre' => $docente->nombre,
                'apellido' => $docente->apellido,
                'identificacion' => $docente->identificacion,
                'numero_resolucion' => $request->numero_resolucion,
                'fecha_emision' => $request->fecha_emision,
                'curso' => $request->curso,
                'calificacion_final' => $request->calificacion_final,
                'tipo_sancion' => $request->tipo_sancion,
                'antecedentes' => $request->antecedentes,
                'fundamentos' => $request->fundamentos,
                'resolucion' => $request->resolucion,
                'firma_path' => $firmaPath,
                'creado_por' => auth()->id(),
                'estado' => 'emitida',
                'fecha_notificacion' => null,
                'fecha_proceso' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('decano.sanciones')->with('success', 'La sanción ha sido registrada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar la sanción: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al guardar la sanción: ' . $e->getMessage());
        }
    }

    /**
     * Muestra la lista de sanciones emitidas.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarSanciones()
    {
        $sanciones = DB::table('proceso_sancion_retiro')
                        ->join('docentes', 'proceso_sancion_retiro.docente_id', '=', 'docentes.id')
                        ->select('proceso_sancion_retiro.*', 'docentes.nombre', 'docentes.apellido', 'docentes.email')
                        ->orderBy('fecha_emision', 'desc')
                        ->paginate(10);

        return response()->view('decano.lista_sanciones', compact('sanciones'));
    }

    /**
     * Genera un PDF de la resolución de sanción.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

public function generarPDFSancion($id)
{
    $sancion = DB::table('proceso_sancion_retiro')
                ->join('docentes', 'proceso_sancion_retiro.docente_id', '=', 'docentes.id')
                ->select('proceso_sancion_retiro.*', 'docentes.nombre', 'docentes.apellido', 'docentes.email')
                ->where('proceso_sancion_retiro.id', $id)
                ->first();

    if (!$sancion) {
        abort(404, 'No se encontró la sanción solicitada.');
    }

    try {
        $pdf = PDF::loadView('decano.pdf_sancion', compact('sancion'));
        return $pdf->download('Resolucion_Sancion_' . $sancion->numero_resolucion . '.pdf');
    } catch (\Exception $e) {
        Log::error('Error al generar PDF de sanción: ' . $e->getMessage());
        abort(500, 'Error al generar el PDF.');
    }
}

    /**
     * Envía la resolución de sanción al docente por correo electrónico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviarResolucion($id)
    {
        try {
            $sancion = DB::table('proceso_sancion_retiro')
                        ->join('docentes', 'proceso_sancion_retiro.docente_id', '=', 'docentes.id')
                        ->select('proceso_sancion_retiro.*', 'docentes.nombre', 'docentes.apellido', 'docentes.email')
                        ->where('proceso_sancion_retiro.id', $id)
                        ->first();

            if (!$sancion) {
                return back()->with('error', 'No se encontró la sanción solicitada.');
            }

            if (!$sancion->email) {
                return back()->with('error', 'El docente no tiene un correo electrónico registrado.');
            }

            // Generar PDF para adjuntar al correo
            $pdf = PDF::loadView('decano.pdf_sancion', compact('sancion'));
            $pdfContent = $pdf->output();
            $pdfFileName = 'Resolucion_Sancion_' . $sancion->numero_resolucion . '.pdf';

            // Enviar correo con la notificación
            // Nota: Debes asegurarte de tener la clase NotificacionSancion implementada
            // Mail::to($sancion->email)
            //     ->send(new NotificacionSancion($sancion, $pdfContent, $pdfFileName));

            // Actualizar la fecha de notificación
            DB::table('proceso_sancion_retiro')
                ->where('id', $id)
                ->update([
                    'fecha_notificacion' => Carbon::now(),
                    'estado' => 'notificada',
                    'updated_at' => now()
                ]);

            return back()->with('success', 'La resolución ha sido enviada correctamente al docente.');
        } catch (\Exception $e) {
            Log::error('Error al enviar resolución: ' . $e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al enviar la resolución al docente: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalles de una sanción específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function verSancion($id)
    // {
    //     try {
    //         $sancion = DB::table('proceso_sancion_retiro')
    //                     ->join('docentes', 'proceso_sancion_retiro.docente_id', '=', 'docentes.id')
    //                     ->select('proceso_sancion_retiro.*', 'docentes.nombre', 'docentes.apellido', 'docentes.email')
    //                     ->where('proceso_sancion_retiro.id', $id)
    //                     ->first();

    //         if (!$sancion) {
    //             return back()->with('error', 'No se encontró la sanción solicitada.');
    //         }

    //         return view('decano.ver_sancion', compact('sancion'));
    //     } catch (\Exception $e) {
    //         Log::error('Error al ver sanción: ' . $e->getMessage());
    //         return back()->with('error', 'Ha ocurrido un error al visualizar la sanción: ' . $e->getMessage());
    //     }
    // }
}
