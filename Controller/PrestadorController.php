<?php

namespace AutoCare\Controller;

use AutoCare\Model\Prestador;

final class PrestadorController extends Controller {
  public static function cadastro() : void {
    parent::isProtected();

    $model = new Prestador();
    $model->nome = "EmpresaTeste";
    $model->apelido = "Testinho";
    $model->endereco_cep = "8180370";
    $model->endereco_numero = "50";
    $model->save();
    echo "Prestador cadastrado com sucesso!";
  }

  public static function listar() : void {
    parent::isProtected();

    echo "listagem de Prestadores";
    $prestador = new Prestador();
    $lista = $prestador->getAllRows();
    var_dump($lista);
  }
}