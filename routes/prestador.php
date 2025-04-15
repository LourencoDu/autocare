<?php

use AutoCare\Controller\PrestadorController;

switch ($url) {
  case '/prestador':
    (new PrestadorController())->listar();
    exit;
  case '/prestador/cadastrar':
    (new PrestadorController())->cadastrar();
    exit;
  case '/prestador/atualizar':
    (new PrestadorController())->atualizar();
    exit;
  case '/prestador/deletar':
    (new PrestadorController())->deletar();
    exit;
}
