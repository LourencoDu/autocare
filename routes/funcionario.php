<?php

use AutoCare\Controller\FuncionarioController;

switch ($url) {
  case '/funcionario':
    (new FuncionarioController())->listar();
    exit;
  case '/funcionario/cadastrar':
    (new FuncionarioController())->cadastrar();
    exit;
  case '/funcionario/atualizar':
    (new FuncionarioController())->atualizar();
    exit;
  case '/funcionario/deletar':
    (new FuncionarioController())->deletar();
    exit;
}
