<?php

use AutoCare\Controller\ServicoController;
use AutoCare\Controller\UsuarioServicoController;

switch ($url) {
  case '/servico':
    $usuario = $_SESSION["usuario"];
    $tipo = $usuario->tipo;
    if($tipo == "usuario") {
      (new UsuarioServicoController())->listar();
    } else {
      (new ServicoController())->listar();
    }
    exit;
  case '/api/servico/listar':
    (new ServicoController())->listarTabela();
    exit;
  case '/api/servico/cadastrar':
    (new ServicoController())->cadastrar();
    exit;
  case '/api/servico/alterar':
    (new ServicoController())->alterar();
    exit;
  case '/api/servico/deletar':
    (new ServicoController())->deletar();
    exit;
  case '/api/servico/alterar_status':
    (new ServicoController())->alterarStatus();
    exit;
}
