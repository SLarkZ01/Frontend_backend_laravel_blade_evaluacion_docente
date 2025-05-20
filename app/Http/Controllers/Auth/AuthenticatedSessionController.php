<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Intentar autenticar al usuario
        $credentials = [
            'correo' => $request->email,
            'contrasena' => $request->password
        ];

        // Buscar el usuario en la base de datos y verificar que esté activo
        $usuario = \App\Models\User::where('correo', $credentials['correo'])
                                ->where('contrasena', $credentials['password'])
                                ->where('activo', true)
                                ->first();

        if ($usuario) {
            // Autenticar manualmente al usuario
            Auth::login($usuario);
            
            // Guardar información en sesión (como en el sistema original)
            Session::put('correo_usuario', $usuario->correo);
            Session::put('rol_usuario', $usuario->id_rol);
            
            $request->session()->regenerate();

            // Redirigir según el rol del usuario utilizando el método getHomeByRole
            return redirect()->intended(RouteServiceProvider::getHomeByRole($usuario->id_rol));
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
