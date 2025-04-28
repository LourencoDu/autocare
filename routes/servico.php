<?php

use AutoCare\Controller\ServicoController;

switch ($url) {
  case '/servico':
    (new ServicoController())->listar();
    exit;
  case '/servico/cadastrar':
    (new ServicoController())->cadastrar();
    exit;
  case '/servico/atualizar':
    (new ServicoController())->atualizar();
    exit;
  case '/servico/deletar':
    (new ServicoController())->deletar();
    exit;
}
