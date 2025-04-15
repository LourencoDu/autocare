<?php

use AutoCare\Controller\FuncionarioController;

switch ($url) {
  case '/functionario':
    (new FuncionarioController())->listar();
    exit;
  case '/functionario/cadastrar':
    (new FuncionarioController())->cadastrar();
    exit;
  case '/functionario/atualizar':
    (new FuncionarioController())->atualizar();
    exit;
  case '/functionario/deletar':
    (new FuncionarioController())->deletar();
    exit;
}
