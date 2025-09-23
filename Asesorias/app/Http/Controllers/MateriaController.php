<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    // Mostrar todas las materias en el inicio
    public function index()
    {
        $materias = Materia::all(); // Trae todas las materias
        return view('inicio', compact('materias'));
    }

    // Mostrar una materia específica con sus unidades y subtemas
    public function show($codigo)
    {
        // Traer la materia con sus unidades y subtemas
        $materia = Materia::with(['unidades.subtemas.contenido']) // Asegúrate de tener la relación 'contenido' en Subtema
            ->where('codigo_materia', $codigo)
            ->first();

        if (!$materia) {
            abort(404, 'Materia no encontrada');
        }

        // Recuperar datos de sesión del docente
        $usuario_nombre = session('usuario', 'Invitado');
        $usuario_id = session('id_usuario');
        $nivel = session('usuario_nivel', 'alumno');

        // Retornar la vista index.blade.php con la materia y datos de sesión
        return view('index', compact('materia', 'usuario_nombre', 'usuario_id', 'nivel'));
    }

    // Guardar nueva materia (desde modal)
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_materia' => 'required|string|unique:materias',
        ]);

        Materia::create([
            'nombre' => $request->nombre,
            'codigo_materia' => $request->codigo_materia,
        ]);

        return redirect()->back()->with('success', 'Materia creada correctamente');
    }
}
