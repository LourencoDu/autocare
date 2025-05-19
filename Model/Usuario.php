<?php

namespace AutoCare\Model;

use AutoCare\DAO\UsuarioDAO;

final class Usuario extends Model
{
  public $id, $nome, $sobrenome, $telefone, $email, $senha, $tipo;

  public static function getById(int $id): ?Usuario
  {
    return (new UsuarioDAO())->selectById($id);
  }

  public function getByEmail(string $email): ?Usuario
  {
    return (new UsuarioDAO())->selectByEmail($email);
  }

  public function getAllRows(): array
  {
    return (new UsuarioDAO())->select();
  }

  public function save(): Usuario
  {
    return (new UsuarioDAO())->save($this);
  }

  public static function alterarSenha(int $id_usuario, string $senha): bool
  {
    return (new UsuarioDAO())->alterarSenha($id_usuario, $senha);
  }

  public static function delete(int $id): bool
  {
    return (new UsuarioDAO())->delete($id);
  }
}
