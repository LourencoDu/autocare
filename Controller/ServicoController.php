<?php

namespace AutoCare\Controller;

use AutoCare\Model\Servico;

final class ServicoController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Servicos";
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
      "editLink" => "/$baseDirName/servico/atualizar",
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


    //validar campos depois
    $this->data = [
      "fields" => [
        
      ]
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $model = new Servico();

        $model->descricao = $_POST["descricao"];
        $model->data = $_POST["data"];
        $model->id_usuario = $_POST["id_usuario"];
        $model->id_prestador = $_POST["id_prestador"];
        $model->id_veiculo = $_POST["id_veiculo"];


        //validar depois
        $this->data["form"] = [
          
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
    $this->titulo = "Atualizar Serviço";


    //validar depois
    $this->data = [
      "fields" => [

      ]
    ];

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
    $this->titulo = "Deletar Serviço";

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
