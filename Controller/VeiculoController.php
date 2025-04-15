<?php

namespace AutoCare\Controller;

use AutoCare\Model\Veiculo;

final class VeiculoController extends Controller {
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Meus Veículos";
    $this->render();
  }

  public static function cadastrar() : void {
    parent::isProtected();

    $model = new Veiculo();
    $model->ano = 2012;
    $model->apelido = "Meu Carro";
    $model->id_modelo_veiculo = 1;


    $model->save();
    echo "Veiculo cadastrado com sucesso!";
  }

  public function listar() : void {
    parent::isProtected();

    $model = new Veiculo();

    $this->data = [
      "lista" => $model->getAllByLoggedUser()
    ];

    $this->index();
  }
}