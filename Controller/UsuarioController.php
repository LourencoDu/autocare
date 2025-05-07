<?php

namespace AutoCare\Controller;

use AutoCare\Model\Usuario;
use AutoCare\Model\Login;

final class UsuarioController extends Controller
{
  public function index(): void
  {
    parent::isProtected();

    $this->view = "Crud/listar.php";
    $this->titulo = "Usuários";
    $this->render();
  }

  public function listar(): void
  {
    parent::isProtected();

    $model = new Usuario();

    $lista = $model->getAllRows();

    $lista = array_filter($lista, function ($item) {
      return $item->id != $_SESSION["usuario"]->id;
    });

    $baseDirName = BASE_DIR_NAME;

    $this->data = [
      "lista" => $lista,
      "addLink" => "/$baseDirName/usuario/cadastrar",
      "editLink" => "/$baseDirName/usuario/atualizar",
      "deleteLink" => "/$baseDirName/usuario/deletar",
    ];

    $this->index();
  }

  private function backToIndex(): void {
    Header("Location: /".BASE_DIR_NAME."/usuario");
  }

  public function cadastrar(): void
  {
    parent::isProtected();

    $this->view = "Crud/form.php";
    $this->titulo = "Novo Usuário";

    $this->caminho = [
      new CaminhoItem("Usuários", "usuario")
    ];

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "sobrenome" => ["name" => "sobrenome", "label" => "Sobrenome", "type" => "text", "required" => true],
        "telefone" => ["name" => "telefone", "label" => "Telefone", "type" => "text", "required" => true],
        "email" => ["name" => "email", "label" => "E-mail", "type" => "email", "required" => true],
        "senha" => ["name" => "senha", "label" => "Senha", "type" => "password", "required" => true]
      ]
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      try {
        $model = new Usuario();

        $model->nome = $_POST["nome"];
        $model->sobrenome = $_POST["sobrenome"];
        $model->telefone = $_POST["telefone"];
        $model->email = $_POST["email"];
        $model->senha = $_POST["senha"];

        $this->data["form"] = [
          "nome" => $model->nome,
          "sobrenome" => $model->sobrenome,
          "telefone" => $model->telefone,
          "email" => $model->email,
          "senha" => $model->senha
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
    $this->titulo = "Atualizar Usuário";

    $this->caminho = [
      new CaminhoItem("Usuários", "usuario")
    ];

    $this->data = [
      "fields" => [
        "nome" => ["name" => "nome", "label" => "Nome", "type" => "text", "required" => true],
        "sobrenome" => ["name" => "sobrenome", "label" => "Sobrenome", "type" => "text", "required" => true],
        "telefone" => ["name" => "telefone", "label" => "Telefone", "type" => "text", "required" => true],
        "email" => ["name" => "email", "label" => "E-mail", "type" => "email", "required" => true, "readonly" => true]
      ]
    ];

    $model = new Usuario();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["form"] = [
          "nome" => $model->nome,
          "sobrenome" => $model->sobrenome,
          "telefone" => $model->telefone,
          "email" => $model->email,
          "senha" => $model->senha
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            $model->nome = $_POST["nome"];
            $model->sobrenome = $_POST["sobrenome"];
            $model->telefone = $_POST["telefone"];
    
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
    $this->titulo = "Deletar Usuário";

    $this->caminho = [
      new CaminhoItem("Usuários", "usuario")
    ];

    $model = new Usuario();
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if($id != null) {
      $model = $model->getById((int) $id);

      if($model != null) {
        $this->data["infos"] = [
          "id" => $model->id,
          "nome" => $model->nome,
          "sobrenome" => $model->nome,
          "telefone" => $model->telefone,
          "email" => $model->email,
        ];
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          try {           
            Usuario::delete((int) $id);
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
