<?php

namespace AutoCare\DAO;

use AutoCare\Model\Especialidade;

final class EspecialidadeDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  public function selectById(int $id): ?Especialidade
  {
    $sql = "SELECT * FROM especialidade WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Especialidade");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM especialidade;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Especialidade");
  }

    public function save(Especialidade $model) : Especialidade
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Especialidade $model) : Especialidade
  {
    $sql = "INSERT INTO especialidade (nome) VALUES (?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Especialidade $model) : Especialidade
  {
    $sql = "UPDATE especialidade SET nome=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->id);
    $stmt->execute();

    return $model;
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM especialidade WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
