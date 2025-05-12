<?php

namespace AutoCare\DAO;

use AutoCare\Model\ModeloVeiculo;

final class ModeloVeiculoDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function selectById(int $id) : ?ModeloVeiculo
  {
    $sql = "SELECT * FROM modelo_veiculo WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\ModeloVeiculo");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM modelo_veiculo;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\ModeloVeiculo");
  }

  public function selectByIdFabricante(int $idFabricante): array
  {
    $sql = "SELECT * FROM modelo_veiculo WHERE id_fabricante_veiculo = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $idFabricante);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\ModeloVeiculo");
  }
}