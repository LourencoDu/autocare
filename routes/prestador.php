<?php

use AutoCare\Controller\PrestadorController;
use AutoCare\Controller\MapController;
use AutoCare\Controller\MapClickController;


switch ($url) {
  case '/prestador':
    if(isset($_GET) && isset($_GET["id"])) {
      (new PrestadorController())->ver();
    } else {
      (new PrestadorController())->listar();
    }
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
  case '/mapaclick': 
    (new MapClickController())->index();
    exit;
}
