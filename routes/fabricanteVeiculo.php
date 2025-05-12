<?php

use AutoCare\Controller\FabricanteVeiculoController;

switch ($url) {
  case '/api/fabricante-veiculo':
    (new FabricanteVeiculoController())->listar(true);
    exit;
}
