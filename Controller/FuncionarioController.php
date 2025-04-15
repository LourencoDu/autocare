<?php

namespace AutoCare\Controller;

use AutoCare\Model\Funcionario;

final class FuncionarioController extends Controller {
  public static function cadastrar() : void {
    parent::isProtected();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $model = new Funcionario();

      $model->nome = $_POST["nome"];
      $model->sobrenome = $_POST["sobrenome"];
      $model->email = $_POST["email"];
      $model->senha = $_POST["senha"];
      $model->id_empresa = $_POST["id_empresa"];
      $model->administrador = $_POST["administrador"];

      $model->save();
  
      echo "Funcionário cadastrado com sucesso!";
    }
  }

  public static function atualizar() : void {
    parent::isProtected();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $model = new Funcionario();

      $model->id = (int) $_POST["id"];
      $model->nome = $_POST["nome"];
      $model->sobrenome = $_POST["sobrenome"];
      $model->email = $_POST["email"];

      $model->save();
  
      echo "Funcionário atualizado com sucesso!";
    }
  }

  public static function listar() : void {
    parent::isProtected();

    echo "listagem de funcionarios";
    $funcionario = new Funcionario();
    $lista = $funcionario->getAllRows();
    var_dump($lista);
  }

  public static function deletar() : void {
    parent::isProtected();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $sucesso = Funcionario::delete((int) $_POST["id"]);

      echo $sucesso ? "Funcionário excluído com sucesso!" : "Falha ao excluir o funcionário!";
    }  
  }
}