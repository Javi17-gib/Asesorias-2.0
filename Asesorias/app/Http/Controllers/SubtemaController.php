<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtema;
use App\Models\Contenido;

class SubtemaController extends Controller
{
    // Mostrar subtema
    public function show($subtemaId)
    {
        // Buscamos el subtema con sus relaciones, si no existe lanzamos 404
        $subtema = Subtema::with(['unidad.materia', 'contenidos'])->findOrFail($subtemaId);

        $usuario_nivel = session('usuario_nivel', 'alumno'); // docente o alumno
        $materia = $subtema->unidad->materia ?? null;

        // Crear contenido inicial si no existe (solo para docentes)
        if ($subtema->contenidos()->count() === 0 && $usuario_nivel === 'docente') {
            Contenido::create([
                'id_subtema' => $subtema->id,
                'id_user' => session('usuario_id'), // ⚡ siempre pasa el usuario logueado
                'titulo' => 'Descripción',
                'contenido' => ''
            ]);
        }

        return view('subtema.show', compact('subtema', 'usuario_nivel', 'materia'));
    }

    // Crear nuevo subtema
    public function store(Request $request)
    {
        $usuario_nivel = session('usuario_nivel', 'alumno');

        if ($usuario_nivel !== 'docente') {
            return response()->json([
                'success' => false,
                'mensaje' => 'No tienes permisos para crear subtemas.'
            ], 403);
        }

        $request->validate([
            'id_unidad' => 'required|exists:unidades,id',
            'nombre' => 'required|string|max:150',
        ]);

        $subtema = Subtema::create([
            'id_unidad' => $request->id_unidad,
            'nombre' => $request->nombre,
        ]);

        return response()->json([
            'success' => true,
            'subtema' => [
                'id' => $subtema->id,
                'nombre' => $subtema->nombre,
                'id_unidad' => $subtema->id_unidad
            ],
            'mensaje' => 'Subtema creado correctamente'
        ]);
    }

    // Guardar descripción de un subtema
    public function guardarDescripcion(Request $request)
    {
        $usuario_nivel = session('usuario_nivel', 'alumno');

        if ($usuario_nivel !== 'docente') {
            return response()->json([
                'success' => false,
                'mensaje' => 'No tienes permisos para editar este contenido.'
            ], 403);
        }

        $request->validate([
            'id_subtema' => 'required|exists:subtemas,id',
            'descripcion' => 'required|string'
        ]);

        $subtema = Subtema::findOrFail($request->id_subtema);
        $contenido = $subtema->contenidos()->first();

        if ($contenido) {
            $contenido->update([
                'contenido' => $request->descripcion,
                'id_user' => session('usuario_id') // ⚡ siempre pasar el usuario logueado
            ]);
        } else {
            // Si por alguna razón no existe, lo creamos
            Contenido::create([
                'id_subtema' => $subtema->id,
                'id_user' => session('usuario_id'),
                'titulo' => 'Descripción',
                'contenido' => $request->descripcion
            ]);
        }

        return response()->json(['success' => true]);
    }
}
