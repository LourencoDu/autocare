<?php
// Cabeçalhos da API
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Lidar com OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$route = trim(str_replace($scriptName, '', $uri), '/');
$segments = explode('/', $route);

// Ex: /usuario ou /usuario/5
$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

switch ($resource) {
    case 'usuario':
        require_once __DIR__ . '/usuario.php';
        handleUsuarioRoute($method, $id);
        break;

    default:
        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada.']);
        break;
}
?>