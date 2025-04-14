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
    $sql = "INSERT INTO prestador (nome, apelido, endereco_cep, endereco_numero) VALUES (?, ?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->apelido);
    $stmt->bindValue(3, $model->endereco_cep);
    $stmt->bindValue(4, $model->endereco_numero);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Prestador $model) : Prestador
  {
    $sql = "UPDATE prestador SET nome=?, apelido=?, endereco_cep=?,  endereco_numero=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->apelido);
    $stmt->bindValue(3, $model->endereco_cep);
    $stmt->bindValue(4, $model->endereco_numero);
    $stmt->bindValue(5, $model->id);
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