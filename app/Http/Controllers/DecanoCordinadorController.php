<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DecanoCordinadorController extends Controller

{
    //
    public function total_docentes()
    {
        $docentes = DB::select('CALL total_docentes()');
        return view('decano.total_docentes', compact('docentes'));
    }
    public function acta_compromiso()
    {
        return view('decano.acta_compromiso');
    }
//alertas bajo desempeño
    public function abd()
    {
        return view('decano.alertas_bajo_desempeno');
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
}
