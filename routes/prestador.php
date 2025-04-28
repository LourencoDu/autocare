<?php

use AutoCare\Controller\PrestadorController;
use AutoCare\Controller\MapController;

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
  case '/prestador/proximos':
    (new MapController())->index();
    exit;
  case '/prestador/proximos/json':
    (new MapController())->listar();
    exit;
}
