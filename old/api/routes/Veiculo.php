<?php
require_once __DIR__ . '/../controller/VeiculoController.php';

function handleUsuarioRoute($method, $id = null) {
    $controller = new VeiculoController();

    switch ($method) {
        case 'GET':
            if ($id) {
                // buscar por ID (você pode implementar isso na model)
                echo json_encode(['erro' => 'Buscar por ID não implementado']);
            } else {
                echo json_encode($controller->read());
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $ok = $controller->create($data);
            echo json_encode(['success' => $ok]);
            break;

        case 'PUT':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['erro' => 'ID obrigatório para atualização']);
                return;
            }
            $data = json_decode(file_get_contents('php://input'), true);
            $data['id'] = $id;
            $ok = $controller->update($data);
            echo json_encode(['success' => $ok]);
            break;

        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['erro' => 'ID obrigatório para exclusão']);
                return;
            }
            $ok = $controller->delete($id);
            echo json_encode(['success' => $ok]);
            break;

        default:
            http_response_code(405);
            echo json_encode(['erro' => 'Método não permitido']);
            break;
    }
}