<?php
require_once __DIR__ . '/../controller/UsuarioController.php';

function handleAutenticacaoRoute($method, $id = null) {
    $controller = new UsuarioController();

    switch ($method) {
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $ok = $controller->login($data);
            echo json_encode(['success' => $ok]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['erro' => 'Método não permitido']);
            break;
    }
}