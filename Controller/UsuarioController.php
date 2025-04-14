<?php

namespace AutoCare\Controller;

use AutoCare\Model\Usuario;

final class UsuarioController {
  public static function cadastro() : void {
    $model = new Usuario();
    $model->nome = "Eduardo";
    $model->sobrenome = "Lourenço da Silva";
    $model->telefone = "13991538145";
    $model->email = "lourenco.e+1@pucpr.edu.br";
    $model->senha = "teste1234";
    $model->save();
    echo "Usuário cadastrado com sucesso!";
  }

  public static function listar() : void {
    echo "listagem de usuários";
    $usuario = new Usuario();
    $lista = $usuario->getAllRows();
    var_dump($lista);
  }
}