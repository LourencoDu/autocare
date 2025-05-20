<?php

use AutoCare\Controller\PrestadorEspecialidadeController;

switch ($url) {
  case '/especialidade/cadastrar':
    (new PrestadorEspecialidadeController())->cadastrar();
    exit;
  case '/especialidade/alterar':
    (new PrestadorEspecialidadeController())->alterar();
    exit;
  case '/api/especialidade/deletar':
    (new PrestadorEspecialidadeController())->deletar();
    exit;
}
