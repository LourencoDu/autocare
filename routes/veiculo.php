<?php

use AutoCare\Controller\VeiculoController;

switch ($url) {
  case '/veiculo':
    (new VeiculoController())->listar();
    exit;
  case '/veiculo/cadastrar':
    (new VeiculoController())->cadastrar();
    exit;
  case '/veiculo/atualizar':
    (new VeiculoController())->atualizar();
    exit;
  case '/veiculo/deletar':
    (new VeiculoController())->deletar();
    exit;
}
