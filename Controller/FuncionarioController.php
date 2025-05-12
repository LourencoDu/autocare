<?php

namespace AutoCare\Controller;

use AutoCare\Model\Funcionario;
use AutoCare\Model\Usuario;

final class FuncionarioController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Funcionarios";
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
      "editLink" => "/$baseDirName/funcionario/alterar",
      "deleteLink" => "/$baseDirName/funcionario/deletar",
    ];

    $this->index();
  }

  private function backToIndex(): void {
    parent::redirect("funcionario");
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Novo Funcionario";

    $this->caminho = [
      new CaminhoItem("Funcionários", "funcionario")
    ];

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "sobrenome" => ["name" => "sobrenome", "label" => "Sobrenome", "type" => "text", "required" => true],
        "email" => ["name" => "email", "label" => "Email", "type" => "text", "required" => true],
        "senha" => ["name" => "senha", "label" => "Senha", "type" => "password", "required" => true],
        "id_prestador" => ["name" => "id_prestador", "label" => "Id_prestador", "type" => "text", "required" => true],
        "administrador" => ["name" => "administrador", "label" => "Administrador", "type" => "text", "required" => true]

      ]
    ];

    if (parent::isPost()) {
      try {
        $model = new Funcionario();
        $usuarioModel = new Usuario();

        $usuarioModel->nome = $_POST["nome"];
        $usuarioModel->sobrenome = $_POST["sobrenome"];
        $usuarioModel->email = $_POST["email"];
        $usuarioModel->senha = $_POST["senha"];
        $usuarioModel->telefone = "";

        $model->id_prestador = $_POST["id_prestador"];
        $model->administrador = $_POST["administrador"] ?? false;

        $this->data["form"] = [
          "nome" => $usuarioModel->nome,
          "sobrenome" => $usuarioModel->sobrenome,
          "email" => $usuarioModel->email,
          "senha" => $usuarioModel->senha,
          "id_prestador" => $model->id_prestador,
          "administrador" => $model->administrador
        ];

        $funcionario = $model->save();
        $usuarioModel->id_funcionario = $funcionario->id;
        $usuarioModel->tipo = "funcionario";
        $usuarioModel->save();

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
    $this->titulo = "Alterar Funcionario";

    $this->caminho = [
      new CaminhoItem("Funcionários", "funcionario")
    ];

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "sobrenome" => ["name" => "sobrenome", "label" => "Sobrenome", "type" => "text", "required" => true],
        "email" => ["name" => "email", "label" => "Email", "type" => "text", "required" => true, "readonly" => true],
      ]
    ];

    $model = new Funcionario();
    $usuarioModel = new Usuario();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $usuarioModel = $usuarioModel->getById((int) $model->usuario->id);

        $this->data["form"] = [
          "nome" => $model->usuario->nome,
          "sobrenome" => $model->usuario->sobrenome,
          "email" => $model->usuario->email,
        ];
    
        if (parent::isPost()) {
          try {           
            $usuarioModel->nome = $_POST["nome"];
            $usuarioModel->sobrenome = $_POST["sobrenome"];
            $usuarioModel->email = $_POST["email"];
    
            $usuarioModel->save();
    
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
    $this->titulo = "Deletar Funcionario";

    $this->caminho = [
      new CaminhoItem("Funcionários", "funcionario")
    ];

    $model = new Funcionario();

    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);
      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "nome" => $model->usuario->nome,
          "sobrenome" => $model->usuario->sobrenome,
          "email" => $model->usuario->email,
          "senha" => $model->usuario->senha,
          "id_prestador" => $model->id_prestador,
          "administrador" => $model->administrador
        ];
    
        if (parent::isPost()) {
          try {          
            Usuario::delete((int) $model->usuario->id);
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
