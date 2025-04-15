<?php

namespace AutoCare\Model;

use AutoCare\DAO\FuncionarioDAO;

final class Funcionario {
  public $id, $nome, $sobrenome, $email, $senha, $id_empresa, $administrador;

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
    $this->senha =  password_hash($this->senha, PASSWORD_DEFAULT);

    return (new FuncionarioDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new FuncionarioDAO())->delete($id);
  }
}