<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\ModeloVeiculo;

final class ModeloVeiculoController extends Controller {
  public function listar($id_fabricante_veiculo = null): void
  {
    parent::isProtected();
    
    $response = null;
 
    try {
      $modelos = $id_fabricante_veiculo ? ModeloVeiculo::getRowsByIdFabricante($id_fabricante_veiculo) : ModeloVeiculo::getAllRows();

      $response = JsonResponse::sucesso("Lista de modelos de veículos carregada com sucesso", $modelos);
    } catch (\Throwable $th) {
      $response = JsonResponse::erro("Falha ao carregar lista de modelos de veículos");
    }

    $response->enviar();
  }
}