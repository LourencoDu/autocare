<?php

namespace AutoCare\Model;

use AutoCare\DAO\UsuarioDAO;

final class Usuario {
  public $id, $nome, $sobrenome, $telefone, $email, $senha;

  public static function getById(int $id) : ?Usuario {
    return (new UsuarioDAO())->selectById($id);
  }

  public function getByEmail(string $email) : ?Usuario {
    return (new UsuarioDAO())->selectByEmail($email);
  }

  public function getAllRows() : array {
    return (new UsuarioDAO())->select();
  }

  public function save() : Usuario {
    $this->senha =  password_hash($this->senha, PASSWORD_DEFAULT);

    return (new UsuarioDAO())->save($this);
  }

  public static function delete(int $id) : bool {
    return (new UsuarioDAO())->delete($id);
  }
}