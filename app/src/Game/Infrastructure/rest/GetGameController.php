<?php

namespace App\Game\Infrastructure\Rest;

use App\Game\Infrastructure\Request as RequestInterface; 
use App\Game\Infrastructure\Response as ResponseInterface; 
use App\Game\Infrastructure\Http\Response; // El Value Object de respuesta

/**
 * Adaptador de Entrada REST: Maneja GET /games.
 * Implementación enfocada en Infrastructure y var_dump.
 */
final class GetGameController
{
    // Mantenemos el constructor, pero ignoramos las dependencias Application/Service.
    public function __construct(
        private ?object $handler, // Será NULL
        private ?object $transformer // Será NULL
    ) {
    }

    /**
     * El método de ejecución.
     */
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        // 1. INSPECCIÓN: Verificar que la Request llegó correctamente
        echo "--- REQUEST DUMP EN GetGameController ---<br>";
        var_dump([
            'URI' => $request->getUri(),
            'Method' => $request->getMethod(),
            'Parameters' => $request->getParameters(),
            'Body' => $request->getBody(),
        ]);
        echo "----------------------------------------<br>";

        // 2. SIMULACIÓN DE RESPUESTA: Crear una respuesta de éxito (200 OK)
        // Esto simula que el Use Case se ejecutó y se transformó la respuesta.
        $successData = [
            'status' => 'success',
            'message' => 'Request handled by GetGameController (Infra only).',
            'data' => [
                'board' => [0, 0, 0, 0, 0, 0, 0, 0, 0],
                'next_player' => 'X'
            ]
        ];

        $body = json_encode($successData);
        
        // 3. Devolver el Value Object de Response de Infraestructura
        return new Response(200, $body);
    }
}