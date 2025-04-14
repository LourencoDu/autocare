<?php

namespace AutoCare\Controller;

use AutoCare\Model\Usuario;

final class UsuarioController extends Controller {
  public static function cadastrar() : void {
    parent::isProtected();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $model = new Usuario();

      $model->nome = $_POST["nome"];
      $model->sobrenome = $_POST["sobrenome"];
      $model->telefone = $_POST["telefone"];
      $model->email = $_POST["email"];
      $model->senha = $_POST["senha"];

      $model->save();
  
      echo "Usuário cadastrado com sucesso!";
    }
  }

  public static function atualizar() : void {
    parent::isProtected();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $model = new Usuario();

      $model->id = (int) $_POST["id"];
      $model->nome = $_POST["nome"];
      $model->sobrenome = $_POST["sobrenome"];
      $model->telefone = $_POST["telefone"];

      $model->save();
  
      echo "Usuário atualizado com sucesso!";
    }
  }

  public static function listar() : void {
    parent::isProtected();

    echo "listagem de usuários";
    $usuario = new Usuario();
    $lista = $usuario->getAllRows();
    var_dump($lista);
  }

  public static function deletar() : void {
    parent::isProtected();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $sucesso = Usuario::delete((int) $_POST["id"]);

      echo $sucesso ? "Usuário excluído com sucesso!" : "Falha ao excluir o usuário!";
    }  
  }
}