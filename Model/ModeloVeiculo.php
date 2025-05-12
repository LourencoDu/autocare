<?php

namespace AutoCare\Model;

use AutoCare\DAO\ModeloVeiculoDAO;

final class ModeloVeiculo extends Model {
  public $id, $nome, $id_fabricante_veiculo;
  
  public static function getById(int $id) : ?ModeloVeiculo {
    return (new ModeloVeiculoDAO())->selectById($id);
  }

  public static function getAllRows() : array {
    return (new ModeloVeiculoDAO())->select();
  }

  public static function getRowsByIdFabricante(int $idFabricante) : array {
    return (new ModeloVeiculoDAO())->selectByIdFabricante($idFabricante);
  }
}