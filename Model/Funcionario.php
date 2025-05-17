<?php

namespace AutoCare\Model;

use AutoCare\DAO\FuncionarioDAO;

final class Funcionario extends Model {
  public $id, $id_prestador, $administrador, $id_usuario;
  public Usuario $usuario;

  public static function getById(int $id) : ?Funcionario {
    return (new FuncionarioDAO())->selectById($id);
  }

  public function getByEmail(string $email) : ?Funcionario {
    return (new FuncionarioDAO())->selectByEmail($email);
  }

  public function getAllRows() : array {
    return (new FuncionarioDAO())->select();
  }

  public function getAllByLoggedUser() : array {
    $usuario = $_SESSION["usuario"];
    if($usuario->tipo == "prestador") {
      $id_prestador = $usuario->prestador->id;

      return $this->getAllByIdPrestador($id_prestador);
    }

    return $this->getAllRows();
  }

  public function getAllByIdPrestador($id_prestador) : array {
    return (new FuncionarioDAO())->selectByIdPrestador($id_prestador);
  }

  public function save() : Funcionario {
    return (new FuncionarioDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new FuncionarioDAO())->delete($id);
  }
}