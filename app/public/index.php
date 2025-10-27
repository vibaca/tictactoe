<?php
declare(strict_types=1);

// ----------------------------------------------------
// 1. LÓGICA PARA SERVIR ARCHIVOS ESTÁTICOS Y SWAGGER UI
// ----------------------------------------------------

// Llamamos a la función antes de cargar el autoload y el Kernel.
serveStaticFileAndExitIfFound(); 

// ----------------------------------------------------
// 2. LÓGICA DE LA APLICACIÓN (TU KERNEL)
// ----------------------------------------------------

use App\Game\Infrastructure\Http\Kernel;
use App\Game\Infrastructure\Http\Request;

require '../vendor/autoload.php';
require '../data/dataset/dataset.php';

// El resto de tu lógica se mantiene igual, ya que solo maneja la API
$kernel = Kernel::createWithDataSet(rankingDataSet());
$request = createRequestFromGlobals();
$response = $kernel->run($request);

http_response_code($response->getStatusCode());
echo $response->getBody();

function createRequestFromGlobals(): Request
{
    // Tu función existente para crear la Request
    $rawMethod = $_SERVER['REQUEST_METHOD'];
    return new Request(
        explode('?', $_SERVER['REQUEST_URI'])[0],
        $rawMethod,
        $_REQUEST,
        file_get_contents('php://input')
    );
}

function serveStaticFileAndExitIfFound(): void
{
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $requestPath = parse_url($requestUri, PHP_URL_PATH);
    $filePath = __DIR__ . $requestPath; 
    
    // --- NUEVA LÓGICA PARA MANEJAR RUTAS A DIRECTORIOS (COMO /swagger) ---
    // Si la URI termina en un path sin extensión (ej. /swagger)
    if (pathinfo($filePath, PATHINFO_EXTENSION) === '' && is_dir($filePath)) {
        // Asumimos que es una solicitud a un directorio que debe servir index.html
        $filePath .= '/index.html'; 
        // Sobreescribimos la extensión para que pase la verificación siguiente
        $extension = 'html'; 
    } else {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    }
    // --------------------------------------------------------------------

    $staticExtensions = ['yaml', 'json', 'css', 'js', 'png', 'svg', 'html', 'woff2', 'ico'];

    // Si la extensión es reconocida Y el archivo ahora existe físicamente
    if (in_array($extension, $staticExtensions) && file_exists($filePath)) {
        
        // ... (El resto de la lógica de Content-Type y headers se mantiene igual) ...
        $mimeType = match ($extension) {
             'yaml' => 'text/yaml',
             'json' => 'application/json',
             'css' => 'text/css',
             'js' => 'application/javascript',
             'html' => 'text/html',
             'svg' => 'image/svg+xml',
             'ico' => 'image/x-icon',
             default => mime_content_type($filePath) ?: 'application/octet-stream',
        };
        
        header("Content-Type: $mimeType");
        header('Cache-Control: public, max-age=31536000');
        
        readfile($filePath);
        exit;
    }
    // Si no es estático, el flujo continúa al Kernel.
}

exit; // Salida original de tu aplicación