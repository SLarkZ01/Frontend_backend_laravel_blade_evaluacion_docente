<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; // <--- Asegúrate de importar esto

class DocenteController extends Controller
{
    //
    public function p_docente()
    {
        $correo = Session::get('correo_usuario');

        if (!$correo) {
            return redirect()->route('user.login')->withErrors(['error' => 'No hay sesión activa. Inicia sesión.']);
        }
    
        // Llamar al procedimiento almacenado
        $evaluaciones = DB::select('CALL ObtenerEvaluacionesPorCorreo(?)', [$correo]);
       // $evaluaciones = $evaluaciones[0] ?? null;
        
        return view('Docente.panel_docente', compact('evaluaciones'));
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
        $correo = Session::get('correo_usuario');
        $notasCursos = DB::select('CALL ObtenerCursosPorCorreo(?)', [$correo]);
        return view('Docente.resultados', compact('notasCursos'));
    }
}
