<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class loginController extends Controller
{
    //
    public function Login()
    {
        
        return view('Login.login');
    }

    public function validation(Request $request)
    {
        //dd("Entró a la función dashboard");
        // Validar los datos del formulario
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Simulación de usuario (puedes cambiar esto por una consulta a la BD)
        $validUser = 'alejo';
        $validPassword = '123';
        $idRol=3;

        
        if ($request->username === $validUser && $request->password === $validPassword) {
            // Guardar sesión (opcional)
            session(['user' => $request->username]);

            // Redirigir a la vista del dashboard
            switch ($idRol) {
                case 1:
                    return redirect()->route('decano.acta_compromiso');
                    break;
                case 2:
                    return redirect()->route('docente.p_docente');
                    break;
                case 3:
                    return redirect()->route('Admin.Dashboard');
                    break;
                default:
                    return redirect()->route('Admin.Dashboard');
                    break;
            }
            
            
        } else {
            // Redirigir con error
            return back()->withErrors(['error' => 'Credenciales incorrectas']);
        }
    }

    
    
}
