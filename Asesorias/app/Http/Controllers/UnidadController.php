<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidad;

class UnidadController extends Controller
{
    public function store(Request $request, $materiaId)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'numero_unidad' => 'required|integer|min:1',
        ]);

        $unidad = Unidad::create([
            'nombre' => $request->nombre,
            'id_materia' => $materiaId,
            'numero_unidad' => $request->numero_unidad,
            'orden' => $request->numero_unidad,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'mensaje' => 'Unidad creada correctamente',
                'unidad' => $unidad
            ]);
        }

        return redirect()->back()->with('success', 'Unidad creada correctamente');
    }
}
