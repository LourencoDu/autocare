<?php

use AutoCare\Controller\{
  CadastroController,
  HomeController,
  LoginController
};

$url = rtrim(str_replace("autocare/", "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)), '/');

// Rotas principais
switch ($url) {
  case '':
    (new HomeController())->index();
    break;
  case '/login':
    (new LoginController())->index();
    break;
  case '/logout':
    LoginController::logout();
    break;
  case '/cadastro':
    (new CadastroController())->index();
    break;
  default:
    require_once __DIR__ . '/usuario.php';
    require_once __DIR__ . '/veiculo.php';
    require_once __DIR__ . '/prestador.php';
    require_once __DIR__ . '/funcionario.php';
    require_once __DIR__ . '/servico.php';

    // Se nenhuma rota for encontrada
    (new HomeController())->index();
    break;
}
