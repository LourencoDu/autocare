<?php

namespace AutoCare\Controller;

use AutoCare\Model\Veiculo;

final class VeiculoController extends Controller {
  public static function cadastrar() : void {
    parent::isProtected();

    $model = new Veiculo();
    $model->ano = 2012;
    $model->apelido = "Meu Carro";
    $model->id_modelo_veiculo = 1;


    $model->save();
    echo "Veiculo cadastrado com sucesso!";
  }

  public static function listar() : void {
    parent::isProtected();

    echo "listagem de Veiculos";
    $prestador = new Veiculo();
    $lista = $prestador->getAllByLoggedUser();
    var_dump($lista);
  }
}