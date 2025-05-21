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

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM especialidade WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
