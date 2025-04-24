<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ActaCompromisoController extends Controller
{
    // API Methods
    public function index()
    {
        $actas = DB::select('CALL GetActasCompromiso()');
        return response()->json($actas);
    }

    public function store(Request $request)
    {
        $result = DB::select('CALL CreateActaCompromiso(?, ?, ?, ?, ?)', [
            $request->docente_id,
            $request->id_facultad,
            $request->id_promedio,
            $request->retroalimentacion,
            $request->fecha_generacion
        ]);

        return response()->json(['message' => 'Acta creada correctamente', 'id' => $result[0]->id_acta ?? null]);
    }

    public function update(Request $request, $id)
    {
        DB::select('CALL UpdateActaCompromiso(?, ?, ?)', [
            $id,
            $request->retroalimentacion,
            $request->fecha_generacion
        ]);

        return response()->json(['message' => 'Acta actualizada correctamente']);
    }

    public function destroy($id)
    {
        DB::select('CALL DeleteActaCompromiso(?)', [$id]);
        return response()->json(['message' => 'Acta eliminada correctamente']);
    }

    // Web View Methods
    public function vistaIndex()
    {
        $actas = DB::select('CALL GetActasCompromiso()');
        return view('Actas.index', compact('actas'));
    }

    public function create()
    {
        // Obtener la lista de docentes para el formulario
        $docentes = DB::select('CALL BuscarDocente()');
        // Obtener las facultades
        $facultades = DB::select('SELECT id_facultad, nombre FROM facultad');
        // Obtener los promedios disponibles
        $promedios = DB::select('SELECT id_promedio, promedio_ev_docente, id_docente FROM promedio_evaluacion_docente_por_curso');
        
        return view('Actas.create', compact('docentes', 'facultades', 'promedios'));
    }

    public function storeVista(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|integer',
            'id_facultad' => 'required|integer',
            'id_promedio' => 'required|integer',
            'retroalimentacion' => 'required|string',
            'fecha_generacion' => 'required|date',
            'firma' => 'nullable|image|max:2048'
        ]);

        $result = DB::select('CALL CreateActaCompromiso(?, ?, ?, ?, ?)', [
            $request->docente_id,
            $request->id_facultad,
            $request->id_promedio,
            $request->retroalimentacion,
            $request->fecha_generacion
        ]);
        
        // Si se cargó una firma, procesarla y actualizar el campo de firma por separado
        if ($request->hasFile('firma') && isset($result[0]->id_acta)) {
            $firma = $request->file('firma');
            $nombreFirma = time() . '_' . $firma->getClientOriginalName();
            $firma->move(public_path('firmas'), $nombreFirma);
            
            // Actualizar solo el campo de firma
            DB::table('acta_compromiso')
                ->where('id_acta', $result[0]->id_acta)
                ->update(['firma' => '/firmas/' . $nombreFirma]);
        }

        return redirect()->route('actas.index')
            ->with('success', 'Acta de compromiso creada correctamente');
    }

    public function show($id)
    {
        $actas = DB::select('CALL GetActaCompromisoById(?)', [$id]);
        $acta = $actas[0] ?? null;
        
        if (!$acta) {
            return redirect()->route('actas.index')
                ->with('error', 'Acta de compromiso no encontrada');
        }
        
        return view('Actas.show', compact('acta'));
    }

    public function edit($id)
    {
        $actas = DB::select('CALL GetActaCompromisoById(?)', [$id]);
        $acta = $actas[0] ?? null;
        
        if (!$acta) {
            return redirect()->route('actas.index')
                ->with('error', 'Acta de compromiso no encontrada');
        }
        
        // Obtener la lista de docentes para el formulario
        $docentes = DB::select('CALL BuscarDocente()');
        
        return view('Actas.edit', compact('acta', 'docentes'));
    }

    public function updateVista(Request $request, $id)
    {
        $request->validate([
            'retroalimentacion' => 'required|string',
            'fecha_generacion' => 'required|date'
        ]);

        DB::select('CALL UpdateActaCompromiso(?, ?, ?)', [
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
        }

        return redirect()->route('actas.index')
            ->with('success', 'Acta de compromiso actualizada correctamente');
    }

    public function destroyVista($id)
    {
        DB::select('CALL DeleteActaCompromiso(?)', [$id]);
        return redirect()->route('actas.index')
            ->with('success', 'Acta de compromiso eliminada correctamente');
    }
}

