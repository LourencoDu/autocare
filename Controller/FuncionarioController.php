<?php

namespace AutoCare\Controller;

use AutoCare\Model\Funcionario;

final class FuncionarioController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Funcionario";
    $this->render();
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Funcionario();

    $lista = $model->getAllRows();

    $baseDirName = BASE_DIR_NAME;

    $this->data = [
      "lista" => $lista,
      "addLink" => "/$baseDirName/funcionario/cadastrar",
      "editLink" => "/$baseDirName/funcionario/atualizar",
      "deleteLink" => "/$baseDirName/funcionario/deletar",
    ];

    $this->index();
  }

  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/funcionario");
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Novo Funcionario";

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "sobrenome" => ["name" => "sobrenome", "label" => "Sobrenome", "type" => "text", "required" => true],
        "email" => ["name" => "email", "label" => "Email", "type" => "text", "required" => true],
        "senha" => ["name" => "senha", "label" => "Senha", "type" => "text", "required" => true],
        "id_empresa" => ["name" => "id_empresa", "label" => "Id_empresa", "type" => "text", "required" => true],
        "administrador" => ["name" => "administrador", "label" => "Administrador", "type" => "text", "required" => true]

      ]
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $model = new Funcionario();

        $model->nome = $_POST["nome"];
        $model->sobrenome = $_POST["sobrenome"];
        $model->email = $_POST["email"];
        $model->senha = $_POST["senha"];
        $model->id_empresa = $_POST["id_empresa"];
        $model->administrador = $_POST["administrador"];

        $this->data["form"] = [
          "nome" => $model->nome,
          "sobrenome" => $model->sobrenome,
          "email" => $model->email,
          "senha" => $model->senha,
          "id_empresa" => $model->id_empresa,
          "administrador" => $model->administrador
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
    $this->titulo = "Atualizar Funcionario";

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "sobrenome" => ["name" => "sobrenome", "label" => "Sobrenome", "type" => "text", "required" => true],
        "email" => ["name" => "email", "label" => "Email", "type" => "text", "required" => true],
      ]
    ];

    $model = new Funcionario();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["form"] = [
          "nome" => $model->nome,
          "sobrenome" => $model->sobrenome,
          "email" => $model->email,
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            $model->nome = $_POST["nome"];
            $model->sobrenome = $_POST["sobrenome"];
            $model->email = $_POST["email"];

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
    $this->titulo = "Deletar Funcionario";

    $model = new Funcionario();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "nome" => $model->nome,
          "sobrenome" => $model->sobrenome,
          "email" => $model->email,
          "senha" => $model->senha,
          "id_empresa" => $model->id_empresa,
          "administrador" => $model->administrador
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            Funcionario::delete((int) $id);
            $this->backToIndex();
          } catch (\Throwable $th) {
            $this->data = array_merge($this->data, [
              "erro" => "Falha ao deletar registro. Erro: ".$th->getMessage(),
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
