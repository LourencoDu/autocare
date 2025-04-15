<?php

namespace AutoCare\DAO;

use AutoCare\Model\Funcionario;

final class FuncionarioDAO extends DAO {
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Funcionario $model) : Funcionario
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Funcionario $model) : Funcionario
  {
    $sql = "INSERT INTO funcionario (nome, sobrenome, email, senha, id_empresa, administrador) VALUES (?, ?, ?, ?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->sobrenome);
    $stmt->bindValue(3, $model->email);
    $stmt->bindValue(4, password_hash($model->senha, PASSWORD_DEFAULT));
    $stmt->bindValue(5, $model->id_empresa);
    $stmt->bindValue(6, $model->administrador);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Funcionario $model) : Funcionario
  {
    $sql = "UPDATE funcionario SET nome=?, sobrenome=?, email=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->sobrenome);
    $stmt->bindValue(3, $model->email);
    $stmt->execute();

    return $model;
  }

  public function selectById(int $id) : ?Funcionario
  {
    $sql = "SELECT * FROM funcionario WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Funcionario");

    return is_object($model) ? $model : null;
  }

  public function selectByEmail(string $email) : ?Funcionario
  {
    $sql = "SELECT * FROM funcionario WHERE email=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $email);
    $stmt->execute();

    return $stmt->fetchObject("AutoCare\Model\Funcionario");
  }

  public function select(): array
  {
    $sql = "SELECT * FROM funcionario;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Funcionario");
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM funcionario WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}