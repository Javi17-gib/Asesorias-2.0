<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Registro
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

        return redirect('/Inicio')->with('success', 'Registro exitoso, bienvenido.');
    }

    // Login
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

        session([
            'usuario_id' => $user->id,
            'usuario_nombre' => $user->nombre,
            'usuario_nivel' => $user->nivel
        ]);

        return redirect('/Inicio')->with('success', 'Bienvenido de nuevo.');
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect('/Login');
    }
}
