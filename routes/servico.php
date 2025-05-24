<?php

use AutoCare\Controller\ServicoController;

switch ($url) {
  case '/servico':
    (new ServicoController())->listar();
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
}
