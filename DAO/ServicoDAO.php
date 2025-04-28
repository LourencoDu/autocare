<?php

namespace AutoCare\DAO;

use AutoCare\Model\Servico;

final class ServicoDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Servico $model) : Servico
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Servico $model) : Servico
  {
    $sql = "INSERT INTO servico (descricao, `data`, id_usuario, id_prestador, id_veiculo) VALUES (?, ?, ?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->descricao);
    $stmt->bindValue(2, $model->data);
    $stmt->bindValue(3, $model->id_usuario);
    $stmt->bindValue(4, $model->id_prestador);
    $stmt->bindValue(5, $model->id_veiculo);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Servico $model) : Servico
  {
    $sql = "UPDATE servico SET descricao=?, `data`=?, id_usuario=?,  id_veiculo=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->descricao);
    $stmt->bindValue(2, $model->data);
    $stmt->bindValue(3, $model->id_usuario);
    $stmt->bindValue(4, $model->id_veiculo);
    $stmt->bindValue(5, $model->id);
    $stmt->execute();

    return $model;
  }

  public function selectById(int $id) : ?Servico
  {
    $sql = "SELECT * FROM servico WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Servico");

    return is_object($model) ? $model : null;
  }

  public function select(): array
  {
    $sql = "SELECT * FROM servico;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Servico");
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM servico WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}