<?php
class App {
    public function __construct() {
        $url = $_GET['url'] ?? 'login';

        switch (strtolower($url)) {
            case 'login':
                require_once 'controller/usuario/LoginController.php';
                $controller = new LoginController();
                break;

            default:
                echo "Controller '$url' não encontrado.";
                return;
        }

        if(isset($controller)) {
            $controller->handle();
        }
    }
}
