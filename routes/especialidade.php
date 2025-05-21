<?php

use AutoCare\Controller\EspecialidadeController;

switch ($url) {
  case '/admin/especialidade':
    (new EspecialidadeController())->listar();
    exit;
  case '/api/admin/especialidade/listar':
    (new EspecialidadeController())->listarTabela();
    exit;
  case '/api/admin/especialidade/cadastrar':
    (new EspecialidadeController())->cadastrar();
    exit;
  case '/api/admin/especialidade/alterar':
    (new EspecialidadeController())->alterar();
    exit;
  case '/api/admin/especialidade/deletar':
    (new EspecialidadeController())->deletar();
    exit;
}
