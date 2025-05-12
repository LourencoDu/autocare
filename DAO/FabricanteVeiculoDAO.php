<?php

namespace AutoCare\DAO;

use AutoCare\Model\FabricanteVeiculo;
use PDO;

final class FabricanteVeiculoDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function selectById(int $id) : ?FabricanteVeiculo
  {
    $sql = "SELECT * FROM fabricante_veiculo WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\FabricanteVeiculo");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM fabricante_veiculo;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\FabricanteVeiculo");
  }
}