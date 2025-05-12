<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\FabricanteVeiculo;

final class FabricanteVeiculoController extends Controller {
  public function listar($json = false): void
  {
    parent::isProtected();
    
    $response = null;

    try {
      $fabricantes = FabricanteVeiculo::getAllRows();

      $response = JsonResponse::sucesso("Lista de fabricantes de veículos carregada com sucesso", $fabricantes);
    } catch (\Throwable $th) {
      $response = JsonResponse::erro("Falha ao carregar lista de fabricantes de veículos");
    }

    $response->enviar();
  }
}