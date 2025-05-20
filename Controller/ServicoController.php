<?php

namespace AutoCare\Controller;

use AutoCare\Model\Servico;

final class ServicoController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Serviços";
    $this->render();
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Servico();

    $lista = $model->getAllRows();

    $baseDirName = BASE_DIR_NAME;

    $this->data = [
      "lista" => $lista,
      "addLink" => "/$baseDirName/servico/cadastrar",
      "editLink" => "/$baseDirName/servico/alterar",
      "deleteLink" => "/$baseDirName/servico/deletar",
    ];

    $this->index();
  }

  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/servico");
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Novo Serviço";

    $this->caminho = [
      new CaminhoItem("Serviços", "servico")
    ];

    $this->data = [
      "fields" => [
        "descricao" => ["name" => "descricao", "label" => "descricao", "type" => "text", "required" => true],
        "data" => ["name" => "data", "label" => "data", "type" => "date", "required" => true],
        "id_usuario" => ["name" => "id_usuario", "label" => "id_usuario", "type" => "number", "required" => true],
        "id_prestador" => ["name" => "id_prestador", "label" => "id_prestador", "type" => "number", "required" => true],
        "id_veiculo" => ["name" => "id_veiculo", "label" => "id_veiculo", "type" => "number", "required" => true]
      ]];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $model = new Servico();

        $model->descricao = $_POST["descricao"];
        $model->data = $_POST["data"];
        $model->id_usuario = $_POST["id_usuario"];
        $model->id_prestador = $_POST["id_prestador"];
        $model->id_veiculo = $_POST["id_veiculo"];

        $this->data = [
          "fields" => [
            "descricao" => ["name" => "descricao", "label" => "descricao", "type" => "text", "required" => true],
            "data" => ["name" => "data", "label" => "data", "type" => "date", "required" => true],
            "id_usuario" => ["name" => "id_usuario", "label" => "id_usuario", "type" => "number", "required" => true],
            "id_prestador" => ["name" => "id_prestador", "label" => "id_prestador", "type" => "number", "required" => true],
            "id_veiculo" => ["name" => "id_veiculo", "label" => "id_veiculo", "type" => "number", "required" => true]
          ]];

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
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Alterar Serviço";

    $this->caminho = [
      new CaminhoItem("Serviços", "servico")
    ];

    $this->data = [
      "fields" => [
        "descricao" => ["name" => "descricao", "label" => "descricao", "type" => "text", "required" => true],
        "data" => ["name" => "data", "label" => "data", "type" => "date", "required" => true],
        "id_usuario" => ["name" => "id_usuario", "label" => "id_usuario", "type" => "number", "required" => true],
        "id_prestador" => ["name" => "id_prestador", "label" => "id_prestador", "type" => "number", "required" => true],
        "id_veiculo" => ["name" => "id_veiculo", "label" => "id_veiculo", "type" => "number", "required" => true]
      ]];

    $model = new Servico();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["form"] = [
          "descricao" => $model->descricao,
          "data" => $model->data,
          "id_usuario" => $model->id_usuario,
          "id_prestador" => $model->id_prestador,
          "id_veiculo" => $model->id_veiculo
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            $model->descricao = $_POST["descricao"];
            $model->data = $_POST["data"];
            $model->id_usuario = $_POST["id_usuario"];
            $model->id_prestador = $_POST["id_prestador"];
            $model->id_veiculo = $_POST["id_veiculo"];
    
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
    parent::isProtected();

    $this->view = "Crud/deletar.php";
    $this->titulo = "Deletar Serviço";

    $this->caminho = [
      new CaminhoItem("Serviços", "servico")
    ];

    $model = new Servico();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "descricao" => $model->descricao,
          "data" => $model->data,
          "id_usuario" => $model->id_usuario,
          "id_prestador" => $model->id_prestador,
          "id_veiculo" => $model->id_veiculo
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            Servico::delete((int) $id);
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
}
