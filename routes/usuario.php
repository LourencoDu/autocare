<?php

use AutoCare\Controller\UsuarioController;

switch ($url) {
  case '/usuario':
    (new UsuarioController())->listar();
    exit;
  case '/usuario/cadastrar':
    (new UsuarioController())->cadastrar();
    exit;
  case '/usuario/alterar':
    (new UsuarioController())->alterar();
    exit;
  case '/usuario/deletar':
    (new UsuarioController())->deletar();
    exit;
}
