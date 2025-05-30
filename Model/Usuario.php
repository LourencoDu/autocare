<?php

namespace AutoCare\Model;

use AutoCare\DAO\UsuarioDAO;

final class Usuario extends Model
{
  public $id, $nome, $sobrenome, $telefone, $email, $senha, $tipo, $reset_token_hash, $token_expire;

  public static function getById(int $id): ?Usuario
  {
    return (new UsuarioDAO())->selectById($id);
  }

  public function getByEmail(string $email): ?Usuario
  {
    return (new UsuarioDAO())->selectByEmail($email);
  }

  public static function getAllRowsByTipo(string $tipo): array
  {
    return (new UsuarioDAO())->selectByTipo($tipo);
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

  public static function recuperarSenha(string $email, string $token_hash): bool
  {
    return (new UsuarioDAO())->recuperarSenha($email, $token_hash);
  }

  public static function validarToken(string $email, string $token_hash): bool
  {
    return (new UsuarioDAO())->validarToken($email, $token_hash);
  }

  public static function atualizarSenha(string $email, string $novaSenha): bool
  {
    return (new UsuarioDAO())->atualizarSenha($email, $novaSenha);
  }
}
