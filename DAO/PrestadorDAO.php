<?php

namespace AutoCare\DAO;

use AutoCare\Model\Prestador;

final class PrestadorDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Prestador $model) : Prestador
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Prestador $model) : Prestador
  {
    $sql = "INSERT INTO prestador (documento, id_usuario) VALUES (?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->documento);
    $stmt->bindValue(2, $model->id_usuario);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Prestador $model)
  {
    $sql = "UPDATE prestador SET documento=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->documento);
    $stmt->bindValue(2, $model->id);
    $stmt->execute();

    return $model;
  }

  public function selectById(int $id) : ?Prestador
  {
    $sql = "SELECT * FROM prestador WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Prestador");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM prestador;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Prestador");
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM prestador WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}