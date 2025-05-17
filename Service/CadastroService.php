<?php

namespace AutoCare\Service;

use AutoCare\Model\Usuario;
use AutoCare\Model\Prestador;
use AutoCare\DAO\DAO; // para acessar $conexao

class CadastroService
{
  public static function cadastrarPrestador($dadosUsuario, $dadosPrestador)
  {
    $pdo = DAO::getConexao();

    try {
      $pdo->beginTransaction();

      $usuario = new Usuario();
      $usuario->nome = $dadosUsuario['nome'];
      $usuario->telefone = $dadosUsuario['telefone'];
      $usuario->email = $dadosUsuario['email'];
      $usuario->senha = $dadosUsuario['senha'];
      $usuario->tipo = $dadosUsuario['tipo'];
      $usuario->save();

      $prestador = new Prestador();
      $prestador->documento = $dadosPrestador['documento'];
      $prestador->id_usuario = $usuario->id;
      $prestador->save();

      $pdo->commit();

      return $usuario;

    } catch (\Throwable $e) {
      $pdo->rollBack();
      throw $e;
    }
  }
}
