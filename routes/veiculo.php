<?php

use AutoCare\Controller\VeiculoController;
use AutoCare\Controller\VeiculoServicoController;

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
  case '/api/veiculo/listar':
    (new VeiculoController())->listarJson();
    exit;
  case '/api/veiculo/deletar':
    (new VeiculoController())->deletar();
    exit;
}
