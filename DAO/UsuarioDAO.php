<?php

namespace AutoCare\DAO;

use AutoCare\Model\Usuario;

final class UsuarioDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  public static function parseRow($data, $prefix = ""): Usuario
  {
    $model = new Usuario();

    $model->id = $data[$prefix . "id"] ?? null;
    $model->nome = $data[$prefix . "nome"] ?? null;
    $model->sobrenome = $data[$prefix . "sobrenome"] ?? null;
    $model->email = $data[$prefix . "email"] ?? null;
    $model->telefone = $data[$prefix . "telefone"] ?? null;
    $model->senha = $data[$prefix . "senha"] ?? null;
    $model->tipo = $data[$prefix . "tipo"] ?? null;

    return $model;
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

  public function selectByTipo(string $tipo): array
  {
    $sql = "SELECT id, nome, sobrenome, email, telefone, tipo FROM usuario WHERE tipo=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $tipo);
    $stmt->execute();

    $resultados = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $linhas = [];

    foreach ($resultados as $linha) {
      $linhas[] = UsuarioDAO::parseRow($linha);
    }

    return $linhas;
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
