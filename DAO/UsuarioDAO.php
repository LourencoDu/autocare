<?php

namespace AutoCare\DAO;

use AutoCare\Model\Usuario;

final class UsuarioDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Usuario $model): Usuario
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Usuario $model): Usuario
  {
    $sql = "INSERT INTO usuario (nome, sobrenome, telefone, email, senha, tipo) VALUES (?, ?, ?, ?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->sobrenome);
    $stmt->bindValue(3, $model->telefone);
    $stmt->bindValue(4, $model->email);
    $stmt->bindValue(5, password_hash($model->senha, PASSWORD_DEFAULT));
    $stmt->bindValue(6, $model->tipo ?? "usuario");
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Usuario $model): Usuario
  {
    $sql = "UPDATE usuario SET nome=?, sobrenome=?, telefone=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->nome);
    $stmt->bindValue(2, $model->sobrenome);
    $stmt->bindValue(3, $model->telefone);
    $stmt->bindValue(4, $model->id);
    $stmt->execute();

    return $model;
  }

  public function alterarSenha(int $id_usuario, string $senha): bool
  {
    $sql = "UPDATE usuario SET senha=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, password_hash($senha, PASSWORD_DEFAULT));
    $stmt->bindValue(2, $id_usuario);
    return $stmt->execute();
  }

  public function selectById(int $id): ?Usuario
  {
    $sql = "SELECT * FROM usuario WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $model = $stmt->fetchObject("AutoCare\Model\Usuario");

    return is_object($model) ? $model : null;
  }

  public function selectByEmail(string $email): ?Usuario
  {
    $sql = "SELECT * FROM usuario WHERE email=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $email);
    $stmt->execute();

    return $stmt->fetchObject("AutoCare\Model\Usuario");
  }

  public function select(): array
  {
    $sql = "SELECT * FROM usuario;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(DAO::FETCH_CLASS, "AutoCare\Model\Usuario");
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM usuario WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
