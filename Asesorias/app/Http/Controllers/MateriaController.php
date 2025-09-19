<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nombre')->get();
        return view('inicio', compact('materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Generar código único
        $ultimo = Materia::latest('id')->first();
        $numero = $ultimo ? str_pad($ultimo->id + 1, 3, '0', STR_PAD_LEFT) : '001';
        $codigo = 'MAT' . $numero;

        // Crear la materia con usuario admin (id=1)
        $materia = Materia::create([
            'nombre' => $request->nombre,
            'codigo_materia' => $codigo,
            'id_users' => 1
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Materia agregada correctamente',
            'materia' => $materia
        ]);
    }
}
