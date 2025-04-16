<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {// Llamar al procedimiento almacenado
        $docentes = DB::select('CALL total_docentes(?)');
        return view('decano.index', [''=> $docentes ]);
    }
}
