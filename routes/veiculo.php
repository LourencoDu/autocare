<?php

use AutoCare\Controller\VeiculoController;

switch ($url) {
  case '/veiculo':
    (new VeiculoController())->listar();
    exit;
  case '/veiculo/cadastrar':
    (new VeiculoController())->cadastrar();
    exit;
  case '/veiculo/alterar':
    (new VeiculoController())->alterar();
    exit;
  case '/api/veiculo/deletar':
    (new VeiculoController())->deletar();
    exit;
}
