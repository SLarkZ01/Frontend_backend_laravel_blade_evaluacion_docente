<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class loginController extends Controller
{
    //
    public function Login()
    {
        
        return view('Login.login');
    }

    public function validation(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    
        // Buscar el usuario en la base de datos
        $usuario = Usuario::where('correo', $request->username)->first();
    
        // Verificar si el usuario existe y la contraseña es correcta
       if ($usuario && $request->password === $usuario->contrasena) {
            // Guardar usuario en la sesión
        //    Auth::login($usuario);
    
            // Redirigir según el rol del usuario
            switch ($usuario->id_rol) {
                case 1:
                    return redirect()->route('decano.acta_compromiso');
                case 2:
                    return redirect()->route('docente.p_docente');
                case 3:
                    return redirect()->route('Admin.Dashboard');
                default:
                    return redirect()->route('Admin.Dashboard');
            }
        } else {
            // Redirigir con mensaje de error
            return back()->withErrors(['error' => 'Credenciales incorrectas']);
        }
    }

    
    
}
