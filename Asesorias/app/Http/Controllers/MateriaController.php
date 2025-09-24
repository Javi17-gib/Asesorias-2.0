<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use Illuminate\Support\Str;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return view('inicio', compact('materias'));
    }

    public function show($codigo)
    {
        $materia = Materia::with(['unidades.subtemas'])
            ->where('codigo_materia', $codigo)
            ->first();

        if (!$materia) abort(404, 'Materia no encontrada');

        $usuario_nombre = session('usuario_nombre', 'Invitado');
        $usuario_id = session('usuario_id');
        $nivel = session('usuario_nivel', 'alumno');

        return view('index', compact('materia', 'usuario_nombre', 'usuario_id', 'nivel'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    // Tomar las primeras 3 letras del nombre, mayúsculas
    $prefix = strtoupper(substr($request->nombre, 0, 3));

    // Contar cuántas materias existen con ese prefijo
    $count = Materia::where('codigo_materia', 'like', $prefix . '%')->count();

    // Generar el código con el contador +1, con 3 dígitos
    $codigo = $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

    // Guardar la materia
    $materia = Materia::create([
        'nombre' => $request->nombre,
        'codigo_materia' => $codigo,
        'id_users' => session('usuario_id'), // registrar el docente que la creó
    ]);

    // Respuesta JSON para AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'mensaje' => 'Materia creada correctamente',
            'materia' => $materia
        ]);
    }

    return redirect()->back()->with('success', 'Materia creada correctamente');
}
}

