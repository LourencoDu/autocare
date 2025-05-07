<?php

namespace AutoCare\Controller;

use AutoCare\Model\Veiculo;

final class VeiculoController extends Controller {
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Veiculo/index.php";
    $this->titulo = "Meus Veículos";
    $this->render();
  }

  private function backToIndex(): void {
    parent::redirect("veiculo");
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Veiculo();

    $lista = $model->getAllRows();

    $this->index();
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Novo Veículo";

    $this->data = [
      "fields" => [
        "ano" => ["name" => "ano", "label" => "Ano", "type" => "number", "required" => true],
        "apelido" => ["name" => "apelido", "label" => "Apelido", "type" => "text", "required" => true],
        "id_modelo_veiculo" => ["name" => "id_modelo_veiculo", "label" => "Modelo Veiculo", "type" => "text", "required" => true]
      ]
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

  public function atualizar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Atualizar Veículo";

    $this->data = [
      "fields" => [
        "ano" => ["name" => "ano", "label" => "Ano", "type" => "number", "required" => true],
        "apelido" => ["name" => "apelido", "label" => "Apelido", "type" => "text", "required" => true],
        "id_modelo_veiculo" => ["name" => "id_modelo_veiculo", "label" => "Modelo Veiculo", "type" => "text", "required" => true]
      ]
    ];

    $model = new Veiculo();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["form"] = [
          "ano" => $model->ano,
          "apelido" => $model->apelido,
          "id_modelo_veiculo" => $model->id_modelo_veiculo
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
              "erro" => "Falha ao atualizar registro. Erro: ".$th->getMessage(),
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
    parent::isProtected();

    $this->view = "Crud/deletar.php";
    $this->titulo = "Deletar Veículo";

    $model = new Veiculo();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "ano" => $model->ano,
          "apelido" => $model->apelido,
          "id_modelo_veiculo" => $model->id_modelo_veiculo,
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            Veiculo::delete((int) $id);
            $this->backToIndex();
          } catch (\Throwable $th) {
            $this->data = array_merge($this->data, [
              "erro" => "Falha ao atualizar registro. Erro: ".$th->getMessage(),
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
}