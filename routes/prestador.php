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
  case '/prestador/alterar':
    (new PrestadorController())->alterar();
    exit;
  case '/prestador/deletar':
    (new PrestadorController())->deletar();
    exit;
  case '/mapa':
    (new MapController())->index();
    exit;
  case '/mapa/json':
    (new MapController())->listar();
    exit;
}
