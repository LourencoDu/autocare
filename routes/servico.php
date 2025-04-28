<?php

use AutoCare\Controller\ServicoController;

switch ($url) {
  case '/servico':
    (new ServicoController())->listar();
    exit;
  case '/servico/cadastrar':
    (new ServicoController())->cadastrar();
    exit;
  case '/prestador/atualizar':
    (new ServicoController())->atualizar();
    exit;
  case '/prestador/deletar':
    (new ServicoController())->deletar();
    exit;
}
