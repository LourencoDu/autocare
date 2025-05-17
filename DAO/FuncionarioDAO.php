<?php

namespace AutoCare\DAO;

use AutoCare\Model\Funcionario;

final class FuncionarioDAO extends DAO
{
  public function __construct()
  {
    parent::__construct();
  }

  public function save(Funcionario $model): Funcionario
  {
    return ($model->id == null) ? $this->insert($model) : $this->update($model);
  }

  private function insert(Funcionario $model): Funcionario
  {
    $sql = "INSERT INTO funcionario (id_prestador, administrador, id_usuario) VALUES (?, ?, ?);";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $model->id_prestador);
    $stmt->bindValue(2, $model->administrador ?? false);
    $stmt->bindValue(3, $model->id_usuario);
    $stmt->execute();

    $model->id = parent::$conexao->lastInsertId();

    return $model;
  }

  private function update(Funcionario $model): Funcionario
  {
    $sql = "UPDATE funcionario SET nome=?, sobrenome=?, email=? WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    // $stmt->bindValue(1, $model->nome);
    // $stmt->bindValue(2, $model->sobrenome);
    // $stmt->bindValue(3, $model->email);
    $stmt->execute();

    return $model;
  }

  public function selectById(int $id): ?Funcionario
  {
    $sql = "SELECT f.*, u.id as u_id, u.nome as u_nome, u.sobrenome as u_sobrenome, u.email as u_email, u.senha as u_senha FROM funcionario f 
    JOIN usuario u ON u.id = f.id_usuario
    WHERE f.id = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();

    $data = $stmt->fetch(DAO::FETCH_ASSOC);

    if ($data) {
      $model = new \AutoCare\Model\Funcionario();

      // preenche os dados do funcionário
      $model->id = $data['id'];
      $model->id_prestador = $data['id_prestador'];
      // ... outros campos do funcionario

      // cria e preenche o usuário
      $usuario = new \AutoCare\Model\Usuario();
      $usuario->id = $data['u_id'];
      $usuario->nome = $data['u_nome'];
      $usuario->sobrenome = $data['u_sobrenome'];
      $usuario->email = $data['u_email'];
      $usuario->senha = $data['u_senha'];

      $model->usuario = $usuario;

      return $model;
    } else {
      return null;
    }
  }

  public function selectByEmail(string $email): ?Funcionario
  {
    $sql = "SELECT * FROM funcionario WHERE email=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $email);
    $stmt->execute();

    return $stmt->fetchObject("AutoCare\Model\Funcionario");
  }

  public function selectByIdPrestador(int $id_prestador): array
  {
    $sql = "SELECT f.id f_id, f.id_prestador f_id_prestador, f.id_usuario f_id_usuario, f.administrador f_administrador, u.id as u_id, u.nome as u_nome, u.sobrenome as u_sobrenome, u.email as u_email, u.senha as u_senha, u.telefone u_telefone, u.tipo u_tipo FROM funcionario f 
    JOIN usuario u ON u.id = f.id_usuario
    WHERE f.id_prestador = ?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id_prestador);
    $stmt->execute();

    $data = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $lista = array();

    foreach ($data as $row) {
      $model = new \AutoCare\Model\Funcionario();

      // preenche os dados do funcionário
      $model->id = $row['f_id'];
      $model->id_prestador = $row['f_id_prestador'];
      $model->id_usuario = $row['f_id_usuario'];
      $model->administrador = $row['f_administrador'];

      // cria e preenche o usuário
      $usuario = new \AutoCare\Model\Usuario();
      $usuario->id = $row['u_id'];
      $usuario->nome = $row['u_nome'];
      $usuario->sobrenome = $row['u_sobrenome'];
      $usuario->telefone = $row['u_telefone'];
      $usuario->tipo = $row['u_tipo'];
      $usuario->email = $row['u_email'];
      $usuario->senha = $row['u_senha'];

      $model->usuario = $usuario;

      array_push($lista, $model);
    }

    return $lista;
  }

  public function select(): array
  {
    $sql = "SELECT f.id f_id, f.id_prestador f_id_prestador, f.id_usuario f_id_usuario, f.administrador f_administrador, u.id as u_id, u.nome as u_nome, u.sobrenome as u_sobrenome, u.email as u_email, u.senha as u_senha, u.telefone u_telefone, u.tipo u_tipo FROM funcionario f 
    JOIN usuario u ON u.id = f.id_usuario;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->execute();

    $data = $stmt->fetchAll(DAO::FETCH_ASSOC);
    $lista = array();

    foreach ($data as $row) {
      $model = new \AutoCare\Model\Funcionario();

      // preenche os dados do funcionário
      $model->id = $row['f_id'];
      $model->id_prestador = $row['f_id_prestador'];
      $model->id_usuario = $row['f_id_usuario'];
      $model->administrador = $row['f_administrador'];

      // cria e preenche o usuário
      $usuario = new \AutoCare\Model\Usuario();
      $usuario->id = $row['u_id'];
      $usuario->nome = $row['u_nome'];
      $usuario->sobrenome = $row['u_sobrenome'];
      $usuario->telefone = $row['u_telefone'];
      $usuario->tipo = $row['u_tipo'];
      $usuario->email = $row['u_email'];
      $usuario->senha = $row['u_senha'];

      $model->usuario = $usuario;

      array_push($lista, $model);
    }

    return $lista;
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM funcionario WHERE id=?;";

    $stmt = parent::$conexao->prepare($sql);
    $stmt->bindValue(1, $id);
    return $stmt->execute();
  }
}
