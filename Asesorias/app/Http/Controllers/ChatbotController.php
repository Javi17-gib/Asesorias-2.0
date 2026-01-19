<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function handleMessage(Request $request)
    {
        // Validación mínima
        $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        // Mensaje de prueba
        $userMessage = $request->input('message') ?? 'Hola, quiero probar la nueva clave';

        try {
            // Llamada a OpenAI
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini', // Cambia a gpt-4 si quieres
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente útil. Responde en español.'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $reply = $response->choices[0]->message->content ?? 'No hay respuesta.';

            return response()->json([
                'success' => true,
                'reply' => $reply
            ]);

        } catch (\Exception $e) {
            // Log de errores
            Log::error('Chatbot error: ' . $e->getMessage());

            // Detecta límite de solicitudes
            if (str_contains($e->getMessage(), 'rate limit')) {
                return response()->json([
                    'success' => false,
                    'reply' => 'Has enviado demasiadas solicitudes. Espera un momento antes de volver a intentar.'//.$e->getMessage()
                ], 429);
            }

            return response()->json([
                'success' => false,
                'reply' => 'Error interno en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}