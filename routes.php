<?php

use AutoCare\Controller\{
    CadastroController,
    HomeController,
  LoginController,
  UsuarioController,
  VeiculoController,
  PrestadorController
};

//armazena parte da url do navegador. de "http://localhost/autocare/usuario" -> armazena o "/usuario"
// o str_replace é necessário na execução via wamp/xamp
$url = str_replace("autocare/", "", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

switch ($url) {
  case '/':
    $controller = new HomeController();
    $controller->index();
    break;
  case '/login':
    $controller = new LoginController();
    $controller->index();
    break;
  case '/logout':
    LoginController::logout();
    break;
  case '/cadastro':
    $controller = new CadastroController();
    $controller->index();
    break;
  case '/usuario':
    UsuarioController::listar();
    break;
  case '/usuario/cadastro':
    UsuarioController::cadastrar();
    break;
  case '/veiculo':
    VeiculoController::listar();
    break;
  case '/veiculo/cadastro':
    VeiculoController::cadastrar();
    break;
  case '/prestador':
    PrestadorController::listar();
    break;
  case '/prestador/cadastro':
    PrestadorController::cadastrar();
    break;
  default:
    $controller = new HomeController();
    $controller->index();
    break;
}
