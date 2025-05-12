<?php

use AutoCare\Controller\ModeloVeiculoController;

switch ($url) {
  case '/api/modelo-veiculo':
    $id_fabricante_veiculo = isset($_GET["id_fabricante_veiculo"]) ? $_GET["id_fabricante_veiculo"] : null;
    (new ModeloVeiculoController())->listar($id_fabricante_veiculo);
    exit;
}
