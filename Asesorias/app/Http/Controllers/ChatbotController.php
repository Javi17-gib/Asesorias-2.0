<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ChatbotController extends Controller
{
    public function handleMessage(Request $request)
    {
        // 1. Validar la entrada
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userMessage = $request->input('message');

        try {
            // 2. Obtener la API Key desde el archivo .env
            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'reply' => 'Error: No se encontró la GEMINI_API_KEY en el archivo .env'
                ], 500);
            }

            $client = new Client();

            // 3. Endpoint actualizado a v1 (más estable para 1.5 Flash)
            $url = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$apiKey}";

            // 4. Petición a la API
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $userMessage]
                            ]
                        ]
                    ],
                    // Opcional: Puedes añadir configuración de generación aquí
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 800,
                    ]
                ]
            ]);

            // 5. Decodificar respuesta
            $data = json_decode($response->getBody(), true);

            // Navegar por la estructura del JSON de Google
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $data['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $reply = 'Lo siento, no pude procesar una respuesta.';
            }

            return response()->json([
                'success' => true,
                'reply' => $reply
            ]);

        } catch (RequestException $e) {
            // Capturar errores específicos de Guzzle/HTTP (404, 401, 429, etc.)
            $errorBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage();
            Log::error('Error en API Gemini: ' . $errorBody);

            return response()->json([
                'success' => false,
                'reply' => 'Error en la comunicación con la IA.',
                'debug' => json_decode($errorBody) // Solo para desarrollo
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error General: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'reply' => 'Ocurrió un error inesperado.'
            ], 500);
        }
    }
}