<?php

namespace AutoCare\Controller;

use AutoCare\Model\Prestador;

final class PrestadorController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Prestadores";
    $this->render();
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Prestador();

    $lista = $model->getAllRows();

    $baseDirName = BASE_DIR_NAME;

    $this->data = [
      "lista" => $lista,
      "addLink" => "/$baseDirName/prestador/cadastrar",
      "editLink" => "/$baseDirName/prestador/atualizar",
      "deleteLink" => "/$baseDirName/prestador/deletar",
    ];

    $this->index();
  }

  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/prestador");
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Novo Prestador";

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "apelido" => ["name" => "apelido", "label" => "Apelido", "type" => "text", "required" => true],
        "endereco_cep" => ["name" => "endereco_cep", "label" => "CEP", "type" => "text", "required" => true],
        "endereco_numero" => ["name" => "endereco_numero", "label" => "Número", "type" => "text", "required" => true]
      ]
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $model = new Prestador();

        $model->nome = $_POST["nome"];
        $model->apelido = $_POST["apelido"];
        $model->endereco_cep = $_POST["endereco_cep"];
        $model->endereco_numero = $_POST["endereco_numero"];

        $this->data["form"] = [
          "nome" => $model->nome,
          "apelido" => $model->apelido,
          "endereco_cep" => $model->endereco_cep,
          "endereco_numero" => $model->endereco_numero
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
    $this->titulo = "Atualizar Prestador";

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "apelido" => ["name" => "apelido", "label" => "Apelido", "type" => "text", "required" => true],
        "endereco_cep" => ["name" => "endereco_cep", "label" => "CEP", "type" => "text", "required" => true],
        "endereco_numero" => ["name" => "endereco_numero", "label" => "Número", "type" => "text", "required" => true]
      ]
    ];

    $model = new Prestador();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["form"] = [
          "nome" => $model->nome,
          "apelido" => $model->apelido,
          "endereco_cep" => $model->endereco_cep,
          "endereco_numero" => $model->endereco_numero
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            $model->nome = $_POST["nome"];
            $model->apelido = $_POST["apelido"];
            $model->endereco_cep = $_POST["endereco_cep"];
            $model->endereco_numero = $_POST["endereco_numero"];

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

    $model = new Prestador();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "nome" => $model->nome,
          "apelido" => $model->apelido,
          "endereco_cep" => $model->endereco_cep,
          "endereco_numero" => $model->endereco_numero
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            Prestador::delete((int) $id);
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
