<?php

namespace AutoCare\Service;

use AutoCare\Model\Usuario;
use AutoCare\Model\Funcionario;
use AutoCare\DAO\DAO;

class FuncionarioService
{
  public static function cadastrarFuncionario($dadosUsuario, $dadosFuncionario)
  {
    $pdo = DAO::getConexao();

    try {
      $pdo->beginTransaction();

      $usuario = new Usuario();
      $usuario->nome = $dadosUsuario['nome'];
      $usuario->sobrenome = $dadosUsuario['sobrenome'];
      $usuario->telefone = $dadosUsuario['telefone'];
      $usuario->email = $dadosUsuario['email'];
      $usuario->senha = $dadosUsuario['senha'];
      $usuario->tipo = "funcionario";
      $usuario->save();

      $funcionario = new Funcionario();
      $funcionario->id_usuario = $usuario->id;
      $funcionario->id_prestador = $dadosFuncionario["id_prestador"];
      $funcionario->administrador = false;
      $funcionario->save();

      $pdo->commit();

      return $funcionario;

    } catch (\Throwable $e) {
      $pdo->rollBack();
      throw $e;
    }
  }
}
