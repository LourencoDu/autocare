<?php

use AutoCare\Controller\{
  HomeController,
  LoginController,
  UsuarioController
};

//armazena parte da url do navegador. de "http://localhost/autocare/usuario" -> armazena o "/usuario"
// o str_replace é necessário na execução via wamp/xamp
$url = str_replace("autocare/", "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

switch ($url) {
  case '/':
  case '/login':
    $controller = new LoginController();
    $controller->index();
    break;
  case '/logout':
    LoginController::logout();
    break;
  case '/home':
    $controller = new HomeController();
    $controller->index();
    break;
  case '/usuario':
    UsuarioController::listar();
    break;
  case '/usuario/cadastro':
    UsuarioController::cadastro();
    break;
  default:
    echo "página não encontrada";
    break;
}
