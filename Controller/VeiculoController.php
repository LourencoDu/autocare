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

  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/veiculo");
  }


  public static function cadastrar() : void {
    parent::isProtected();

    $model = new Veiculo();
    $model->ano = $_POST["ano"];;
    $model->apelido = $_POST["apelido"];
    $model->id_usuario = $_POST["id_usuario"];
    $model->id_modelo_veiculo = $_POST["id_modelo_veiculo"];


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

  public function atualizar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Atualizar Veiculo";

    $this->data = [
      "fields" => [
        "ano" => ["name" => "ano", "label" => "ano", "type" => "int", "required" => true],
        "apelido" => ["name" => "apelido", "label" => "apelido", "type" => "text", "required" => true],
        "id_modelo_veiculo" => ["name" => "id_modelo_veiculo", "label" => "id_modelo_veiculo", "type" => "int", "required" => true]
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

            var_dump($model);
    
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
    $this->titulo = "Deletar Prestador";

    $model = new Veiculo();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "ano" => $model->ano,
          "apelido" => $model->apelido,
          "id_usuario" => $model->id_usuario,
          "id_modelo_veiculo" => $model->id_modelo_veiculo
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