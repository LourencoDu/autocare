<?php
require_once __DIR__ . '/../controller/UsuarioController.php';

$controller = new UsuarioController();
$action = $_GET['action'] ?? 'read';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $controller->create($_POST);
            echo $ok ? "Usuário criado!" : "Erro ao criar.";
        }
        break;

    case 'read':
        $usuarios = $controller->read();
        echo "<pre>" . print_r($usuarios, true) . "</pre>";
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $controller->update($_POST);
            echo $ok ? "Usuário atualizado!" : "Erro ao atualizar.";
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $controller->delete($_POST['id']);
            echo $ok ? "Usuário excluído!" : "Erro ao excluir.";
        }
        break;

    default:
        http_response_code(404);
        echo "Ação '{$action}' não encontrada em Usuario.";
        break;
}
