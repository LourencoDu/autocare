<?php

namespace AutoCare\Controller;

use AutoCare\Helper\JsonResponse;
use AutoCare\Model\FabricanteVeiculo;
use AutoCare\Model\ModeloVeiculo;
use AutoCare\Model\Veiculo;

final class VeiculoController extends Controller {
  public function index(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $this->view = "Veiculo/index.php";
    $this->titulo = "Meus Veículos";
    $this->render();
  }

  private function backToIndex(): void {
    parent::redirect("veiculo");
  }

  public function listar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $model = new Veiculo();

    $veiculos = $model->getAllByLoggedUser();
    $this->data["veiculos"] = $veiculos;

    $this->js = "Veiculo/script.js";

    $this->index();
  }

  public function cadastrar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $this->view = "Veiculo/form.php";
    $this->js = "Veiculo/form.js";
    $this->titulo = "Novo Veículo";


    $this->caminho = [
      new CaminhoItem("Meus Veículos", "veiculo")
    ];

    $this->data = [
      "fabricantes" => FabricanteVeiculo::getAllRows()
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $model = new Veiculo();

        $model->ano = $_POST["ano"];
        $model->apelido = $_POST["apelido"];
        $model->id_modelo_veiculo = $_POST["id_modelo_veiculo"];

        $this->data["form"] = [
          "ano" => $model->ano,
          "apelido" => $model->apelido,
          "id_modelo_veiculo" => $model->id_modelo_veiculo
        ];

        $model->save();

        $this->backToIndex();
      } catch (\Throwable $th) {
        $this->data = array_merge($this->data, [
          "erro" => "Falha ao adicionar registro. Erro: ".$th->getMessage(),
          "exception" => $th->getMessage()
        ]);
      }
    }

    $this->render();
  }

  public function alterar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $this->view = "Veiculo/form.php";
    $this->js = "Veiculo/form.js";

    $model = new Veiculo();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $modeloModel = ModeloVeiculo::getById($model->id_modelo_veiculo);
        $id_fabricante_veiculo = $modeloModel->id_fabricante_veiculo;

        $this->titulo = 'Alterar "'.$model->apelido.'"';

        $this->caminho = [
          new CaminhoItem("Meus Veículos", "veiculo"),
        ];

        $this->data = [
          "fabricantes" => FabricanteVeiculo::getAllRows(),
          "modelos" => ModeloVeiculo::getRowsByIdFabricante($id_fabricante_veiculo),
          "action" => "alterar"
        ];

        $this->data["form"] = [
          "ano" => $model->ano,
          "apelido" => $model->apelido,
          "id_modelo_veiculo" => $model->id_modelo_veiculo,
          "id_fabricante_veiculo" => $id_fabricante_veiculo
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            $model->ano = $_POST["ano"];
            $model->apelido = $_POST["apelido"];
            $model->id_modelo_veiculo = $_POST["id_modelo_veiculo"];
    
            $model->save();
    
            $this->backToIndex();
          } catch (\Throwable $th) {
            $this->data = array_merge($this->data, [
              "erro" => "Falha ao alterar registro. Erro: ".$th->getMessage(),
              "exception" => $th->getMessage()
            ]);
          }
        }
    
        $this->render();
      }  else {
        $this->backToIndex();
      }    
    } else {
      $this->backToIndex();
    }
  }

  public function deletar(): void
  {
    parent::isProtected(["prestador", "funcionario"]);

    $id = isset($_POST["id"]) ? $_POST["id"] : null;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $response = null;
      try {           
        Veiculo::delete((int) $id);

        $response = JsonResponse::sucesso("Veículo deletado com sucesso!");
      } catch (\Throwable $th) {
        $response = JsonResponse::erro("Falha ao deletar veículo!");
      }

      $response->enviar();
    }
  }
}