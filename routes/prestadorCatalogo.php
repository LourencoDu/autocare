<?php

use AutoCare\Controller\PrestadorCatalogoController;

switch ($url) {
  case '/catalogo/cadastrar':
    (new PrestadorCatalogoController())->cadastrar();
    exit;
  case '/catalogo/alterar':
    (new PrestadorCatalogoController())->alterar();
    exit;
  case '/api/catalogo/deletar':
    (new PrestadorCatalogoController())->deletar();
    exit;
}
