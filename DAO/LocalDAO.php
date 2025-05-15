<?php
//Copia do PrestadorDAO por enquanto 
namespace AutoCare\DAO;

use AutoCare\Model\Local;

final class LocalDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Local $model) : Local
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Local $model) : Local
{
    $sql = "INSERT INTO localizacao (latitude, longitude) VALUES (?, ?);";
    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->latitude);
    $stmt->bindValue(2, $model->longitude);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();
    return $model;
}

private function update(Local $model) : Local
{
    $sql = "UPDATE localizacao SET latitude=?, longitude=? WHERE id=?;";
    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->latitude);
    $stmt->bindValue(2, $model->longitude);
    $stmt->bindValue(3, $model->id);
    $stmt->execute();

    return $model;
}


  public function selectById(int $id) : ?Local
  {
    $sql = "SELECT * FROM localizacao WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Local");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM localizacao;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Local");
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM localizacao WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}