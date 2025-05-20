<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Obtener los roles disponibles para mostrar en el formulario de registro
        $roles = \App\Models\Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:usuarios,correo'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'integer', 'exists:roles,id_rol'],
        ]);

        $user = User::create([
            'nombre' => $request->name,
            'correo' => $request->email,
            'contrasena' => $request->password, // No usamos Hash porque el sistema actual no lo usa
            'id_rol' => $request->role, // Usamos el rol seleccionado del formulario
            'activo' => true
        ]);
        
        // Guardar información en sesión (como en el sistema original)
        Session::put('correo_usuario', $user->correo);
        Session::put('rol_usuario', $user->id_rol);

        event(new Registered($user));

        Auth::login($user);

        // Redirigir según el rol del usuario utilizando el método getHomeByRole
        return redirect(RouteServiceProvider::getHomeByRole($user->id_rol));
    }
}
