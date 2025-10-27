<?php

namespace App\Game\Infrastructure\Http;
use App\Game\Infrastructure\Kernel as KernelInterface;
use App\Game\Infrastructure\Request as RequestInterface;
use App\Game\Infrastructure\Response as ResponseInterface;
use App\Game\Infrastructure\Rest\GetGameController;
class Kernel implements KernelInterface {

    public static function createWithDataSet(array $dataset): static {
        return new static($dataset);
    }
    private function __construct(private array $dataset) {
        // TODO: it's mandatory to bootstrap this application so that the data used is the one provided in the dataset :D
    }

    public function run(RequestInterface $request): ResponseInterface {

        // Paso 1: Enrutamiento manual (solo GET /games)
        if ($request->getMethod() === 'GET' && $request->getUri() === '/games') {
            
            // Paso 2: Despacho. Instanciar el Controller directamente.
            // OJO: Pasamos NULL para las dependencias de Application/Service que vamos a ignorar
            $controller = new GetGameController(null, null); 
            
            // Paso 3: Ejecutar el Controller
            return $controller($request);
        }
        
        // Si no es la ruta GET /games
        $body = json_encode(['error' => 'Not Found']);
        return new Response(404, $body);

    }
}
