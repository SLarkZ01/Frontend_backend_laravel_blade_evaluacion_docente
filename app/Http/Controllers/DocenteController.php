<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocenteController extends Controller
{
    //
    public function p_docente()
    {
        return view('Docente.panel_docente');
    }

    public function confi()
    {
        return view('Docente.configuracion');
    }

    public function pde()
    {
        return view('Docente.panel_docente_enhanced');
    }

    public function result()
    {
        return view('Docente.resultados');
    }
}
