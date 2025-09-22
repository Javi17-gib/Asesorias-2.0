<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nombre')->get();
        $nivel = session('usuario_nivel'); // Traemos el nivel de usuario de la sesión
        return view('Inicio', [
        'materias' => $materias,
        'nivel' => session('usuario_nivel'),
    ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $user_id = session('usuario_id');

        if(session('usuario_nivel') !== 'docente'){
            return response()->json(['success' => false, 'mensaje' => 'No tienes permisos.']);
        }

        $ultimo = Materia::latest('id')->first();
        $numero = $ultimo ? str_pad($ultimo->id + 1, 3, '0', STR_PAD_LEFT) : '001';
        $codigo = 'MAT' . $numero;

        $materia = Materia::create([
            'nombre' => $request->nombre,
            'codigo_materia' => $codigo,
            'id_users' => $user_id
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Materia agregada correctamente',
            'materia' => $materia
        ]);
    }
}
