<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidad;
use App\Models\Subtema;

class UnidadController extends Controller
{
    // Guardar unidad
    public function store(Request $request) {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'nombre' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        Unidad::create([
            'id_materia' => $request->materia_id,
            'nombre' => $request->nombre,
            'orden' => $request->orden ?? 1,
        ]);

        return redirect()->back()->with('success', 'Unidad creada correctamente');
    }

    // Guardar subtema
    public function storeSubtema(Request $request) {
        $request->validate([
            'unidad_id' => 'required|exists:unidades,id',
            'nombre' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        Subtema::create([
            'id_unidad' => $request->unidad_id,
            'nombre' => $request->nombre,
            'orden' => $request->orden ?? 1,
        ]);

        return redirect()->back()->with('success', 'Subtema creado correctamente');
    }
}
