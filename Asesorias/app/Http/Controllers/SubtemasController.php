<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtema;

class SubtemaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'unidad_id' => 'required|integer|exists:unidades,id',
        ]);

        $subtema = Subtema::create([
            'nombre' => $request->nombre,
            'id_unidad' => $request->unidad_id,
            'orden' => 1
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'mensaje' => 'Subtema creado correctamente',
                'subtema' => $subtema
            ]);
        }

        return redirect()->back()->with('success', 'Subtema creado correctamente');
    }
}
