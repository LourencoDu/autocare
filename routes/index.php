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
  case '/home':
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
  case '/cadastro/bem-vindo':
    (new CadastroController())->exibirBemVindo();
    break;
  default:
    require_once __DIR__ . '/meuPerfil.php';
    require_once __DIR__ . '/usuario.php';
    require_once __DIR__ . '/prestador.php';
    require_once __DIR__ . '/funcionario.php';
    require_once __DIR__ . '/servico.php';
    require_once __DIR__ . '/chat.php';
    require_once __DIR__ . '/veiculo.php';
    require_once __DIR__ . '/fabricanteVeiculo.php';
    require_once __DIR__ . '/modeloVeiculo.php';

    // Se nenhuma rota for encontrada
    (new HomeController())->index();
    break;
}
