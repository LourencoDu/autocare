<?php

namespace AutoCare\Controller;

use AutoCare\Model\Prestador;

final class PrestadorController extends Controller {
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Prestadores";
    $this->render();
  }

  public static function cadastrar() : void {
    parent::isProtected();

    $model = new Prestador();
    $model->nome = "EmpresaTeste";
    $model->apelido = "Testinho";
    $model->endereco_cep = "8180370";
    $model->endereco_numero = "50";
    $model->save();
    echo "Prestador cadastrado com sucesso!";
  }

  public function listar() : void {
    parent::isProtected();

    $model = new Prestador();
    
    $this->data = [
      "lista" => $model->getAllRows()
    ];

    $this->index();
  }
}