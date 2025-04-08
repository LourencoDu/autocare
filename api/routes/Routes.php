<?php
$route = $_GET['route'] ?? '';

$parts = explode('/', $route);
$resource = $parts[0] ?? '';
$action = $parts[1] ?? 'read';

$routeFile = __DIR__ . "/routes/{$resource}.php";

if (file_exists($routeFile)) {
    $_GET['action'] = $action;
    require $routeFile;
} else {
    http_response_code(404);
    echo "Rota '{$route}' não encontrada.";
}
