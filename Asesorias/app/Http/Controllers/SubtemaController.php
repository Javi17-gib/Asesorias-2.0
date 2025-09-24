<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtema;

class SubtemaController extends Controller
{
   public function store(Request $request)
{
    try {
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
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'mensaje' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // Aquí capturamos cualquier excepción para ver el mensaje
        \Log::error('Error en SubtemaController@store: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'mensaje' => 'Error interno del servidor: ' . $e->getMessage()
        ], 500);
    }
}

}
                       