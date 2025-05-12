<?php

namespace AutoCare\Controller;

use AutoCare\Model\Usuario;
use AutoCare\Model\Prestador;

final class CadastroController extends Controller
{
  public function index(): void
  {
    $this->view = "Cadastro/index.php";
    $this->js = "Cadastro/script.js";

    $this->titulo = "Cadastro";
    if (parent::isPost()) {
      $this->cadastrar();
    } else if (isset($_GET["tipoUsuario"])) {
      if ($_GET["tipoUsuario"] == "usuario") {
        $this->exibirCadastroUsuario();
      } else if ($_GET["tipoUsuario"] == "prestador") {
        $this->exibirCadastroPrestador();
      }
    }
    $this->render();
  }

  private function exibirCadastroUsuario()
  {
    $this->view = "Cadastro/usuario/index.php";
    $this->js = "Cadastro/usuario/script.js";
  }

  private function exibirCadastroPrestador()
  {
    $this->view = "Cadastro/prestador/index.php";
    $this->js = "Cadastro/prestador/script.js";
  }

  public function exibirBemVindo()
  {
    $this->titulo = "Bem-vindo";
    $this->view = "Cadastro/bem-vindo/index.php";

    $this->data["tipoUsuario"] = $_GET["tipoUsuario"] ?? "usuario";

    $this->render();
  }

  private function cadastrar(): void
  {
    $tipoUsuario = $_POST["tipoUsuario"];

    if ($tipoUsuario === "usuario") {
      $this->cadastrarUsuario();
    } else {
      $this->cadastrarPrestador();
    }
  }

  private function cadastrarUsuario(): void
  {
    $tipoUsuario = "usuario";

    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if (!$nome || !$sobrenome || !$telefone || !$email || !$senha) {
      $this->data['erro'] = "Preencha todos os campos obrigatórios (*).";
      $this->data['form'] = [
        "tipoUsuario" => $tipoUsuario,
        "nome" => $nome,
        "sobrenome" => $sobrenome,
        "telefone" => $telefone,
        "email" => $email,
        "senha" => $senha,
      ];
      return;
    }

    try {
      $model = new Usuario();

      $model->nome = $nome;
      $model->sobrenome = $sobrenome;
      $model->telefone = $telefone;
      $model->email = $email;
      $model->senha = $senha;

      $model->save();

      Header("Location: /" . BASE_DIR_NAME . "/cadastro/bem-vindo?tipoUsuario=".$tipoUsuario);
    } catch (\Throwable $th) {
      $this->data = array_merge($this->data ?? [], [
        "erro" => "Falha ao adicionar registro. Erro: " . $th->getMessage(),
        "exception" => $th->getMessage()
      ]);
    }
  }

  private function cadastrarPrestador(): void
  {
    $tipoUsuario = "prestador";

    $nome = $_POST["nome"];
    $documento = $_POST["documento"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    if (!$nome || !$documento || !$telefone || !$email || !$senha) {
      $this->data['erro'] = "Preencha todos os campos obrigatórios (*).";
      $this->data['form'] = [
        "tipoUsuario" => $tipoUsuario,
        "nome" => $nome,
        "documento" => $documento,
        "telefone" => $telefone,
        "email" => $email,
        "senha" => $senha,
      ];
      return;
    }

    try {
      $modelUsuario = new Usuario();

      $modelUsuario->nome = $nome;
      $modelUsuario->telefone = $telefone;
      $modelUsuario->email = $email;
      $modelUsuario->senha = $senha;
      $modelUsuario->tipo = $tipoUsuario;

      $modelUsuario->save();

      $modelPrestador = new Prestador();
      $modelPrestador->documento = $documento;
      $modelPrestador->id_usuario = $modelUsuario->id;
      $modelPrestador->save();

      Header("Location: /" . BASE_DIR_NAME . "/cadastro/bem-vindo?tipoUsuario=".$tipoUsuario);
    } catch (\Throwable $th) {
      $this->data = array_merge($this->data ?? [], [
        "erro" => "Falha ao adicionar registro. Erro: " . $th->getMessage(),
        "exception" => $th->getMessage()
      ]);
    }
  }
}
