<?php

namespace AutoCare\Model;

use AutoCare\DAO\FuncionarioDAO;

final class Funcionario extends Model {
  public $id, $id_prestador, $administrador;
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

  public function save() : Funcionario {
    return (new FuncionarioDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new FuncionarioDAO())->delete($id);
  }
}