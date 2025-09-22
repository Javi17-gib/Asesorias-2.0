<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ap_paterno' => 'required|string|max:100',
            'ap_materno' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nivel' => 'required|in:alumno,docente',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'email' => $request->email,
            'nivel' => $request->nivel,
            'password' => Hash::make($request->password),
        ]);

        session([
            'usuario_id' => $user->id,
            'usuario_nombre' => $user->nombre,
            'usuario_nivel' => $user->nivel
        ]);

        return redirect()->route('login.form')->with('success', '¡Registro exitoso! Ahora inicia sesión.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Correo o contraseña incorrectos.');
        }

        // Guardar datos del usuario en sesión
        session([
            'usuario_id' => $user->id,
            'usuario_nombre' => $user->nombre,
            'usuario_nivel' => $user->nivel
        ]);

        return redirect()->route('Inicio')->with('success', 'Bienvenido de nuevo.');
    }

    public function logout()
    {
        session()->flush();               // Borra todos los datos de sesión
        session()->invalidate();          // Invalida la sesión actual
        session()->regenerateToken();     // Protege contra CSRF

        return redirect()->route('login.form');
    }
}
