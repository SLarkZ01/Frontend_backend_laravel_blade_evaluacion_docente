<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; // <--- Asegúrate de importar esto

class loginController extends Controller
{
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

        // Llamar al procedimiento almacenado
        $usuario = DB::select('CALL ObtenerUsuarioPorCorreo(?)', [$request->username]);
        $usuario = $usuario[0] ?? null;

        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario && $request->password === $usuario->contrasena) {

            // ✅ GUARDAR EN SESIÓN
            Session::put('correo_usuario', $usuario->correo);
            Session::put('rol_usuario', $usuario->id_rol); // También puedes guardar el rol si lo necesitas

            // Redirigir según el rol del usuario
            switch ($usuario->id_rol) {
                case 1:
                   // return redirect()->route('decano.acta_compromiso');
                    return redirect()->route('user.index');
                case 2:
                    return redirect()->route('docente.p_docente');
                case 3:
                    return redirect()->route('Admin.Dashboard');
                default:
                    return redirect()->route('Admin.Dashboard');
            }

        } else {
            return back()->withErrors(['error' => 'Credenciales incorrectas']);
        }
    }
}