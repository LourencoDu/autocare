<?php

namespace AutoCare\Model;

use AutoCare\DAO\FabricanteVeiculoDAO;

final class FabricanteVeiculo extends Model {
  public $id, $nome;
  
  public static function getById(int $id) : ?FabricanteVeiculo {
    return (new FabricanteVeiculoDAO())->selectById($id);
  }

  public static function getAllRows() : array {
    return (new FabricanteVeiculoDAO())->select();
  }
}